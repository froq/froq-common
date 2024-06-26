<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

use froq\common\interface\Thrownable;
use froq\util\Debugger;
use Throwable, State, TraceStack, Trace;

/**
 * A trait, used by error & exception classes, provides a relaxation getting rid
 * of `sprintf()` calls for messages, has some utility methods and cause property
 * as well.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\ThrownableTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait ThrownableTrait
{
    /** Cause of this error/exception. */
    private ?Throwable $cause = null;

    /** State holder. */
    private ?State $state = null;

    /**
     * Constructor.
     *
     * @param string|int|Throwable|null $message
     * @param mixed|null                $messageParams
     * @param int|null                  $code
     * @param Throwable|null            $previous
     * @param Throwable|null            $cause
     * @param mixed                  ...$options Valids extract, lower, reduce, state.
     */
    public function __construct(string|int|Throwable $message = null, mixed $messageParams = null, int|string $code = null,
        Throwable $previous = null, Throwable $cause = null, mixed ...$options)
    {
        [$extract, $lower, $reduce, $state] = $this->prepareOptions($options);

        // Shortcut for code.
        if (is_int($message)) {
            $code = $message;
            $message = null;
        }

        // Works here only.
        if (is_string($code)) {
            $this->setCode($code);
            $code = null;
        }

        if ($message) {
            if (is_string($message)) {
                $error = self::lastError();

                // Drop eg: "mkdir():" part & lowerize.
                $extract && $error['message'] = self::extractMessage($error['message']);
                $lower   && $error['message'] = lower($error['message']);

                // Replace '@error' directive with last (current) error.
                $message = str_replace('@error', $error['message'], $message);

                // Eg: throw new Exception('@error').
                if ($message === '@error') {
                    $code  ??= $error['code'];
                    $message = $error['message'];
                }
                // Eg: throw new Exception('Error: %s', ['The error!'] or ['@error']).
                elseif (func_num_args() > 1) {
                    $messageParams = is_array($messageParams) || is_scalar($messageParams)
                        ? (array) $messageParams : [$messageParams];

                    // Prevent named argument stuff for format().
                    $messageParams = array_values($messageParams);

                    foreach ($messageParams as $i => $messageParam) {
                        if ($messageParam === '@error') {
                            $code            ??= $error['code'];
                            $messageParams[$i] = $error['message'];
                            break;
                        }
                    }

                    $message = format($message, ...$messageParams);
                }
            } else {
                $cause   = $message;
                $code  ??= $message->getCode();
                $message = $message->getMessage();
            }

            // Drop eg: "RegexIterator::__construct():" part.
            $extract && $message = self::extractMessage($message);
        }

        $this->cause = $cause;

        if ($state !== null) {
            $this->state = new State((array) $state);
        }

        parent::__construct((string) $message, (int) $code, $previous);

        // Try to detect that this created via some static::for*() method.
        // Eg: if ($id < 0) throw UserError::forInvalidId($id).
        if ($reduce === null) {
            $trace = $this->getTraceItem(0);
            if (isset($trace['class'], $trace['function'])
                && is_class_of($trace['class'], Throwable::class)
                && str_starts_with($trace['function'], 'for')) {
                $reduce = 1;
            }
        }

        $this->applyReduce((int) $reduce);
    }

    /**
     * @magic
     */
    public function __get(string $property): mixed
    {
        switch ($property) {
            case 'trace':
                return $this->getTrace();
            case 'traceStack':
                return $this->getTraceStack();
            case 'tracePath':
                return $this->getTracePath();
            case 'traceString':
                return $this->getTraceString();
            case 'cause':
                return $this->getCause();
            case 'state':
                return $this->getState();
        }

        // If subclasses define property as "private".
        if (property_exists($this, $property)) {
            $ref = new \ReflectionProperty($this, $property);
            return $ref->isInitialized($this) ? $ref->getValue($this) : $ref->getDefaultValue();
        }

        // Act as original just triggering an undefined property error.
        trigger_error(format('Undefined property: %S::$%s', $this::class, $property), E_USER_WARNING);

        return null;
    }

    /**
     * @magic
     */
    public function __toString(): string
    {
        return Debugger::debugString($this);
    }

    /**
     * Set message.
     *
     * @param  string    $message
     * @param  mixed  ...$messageParams
     * @return self
     */
    public function setMessage(string $message, mixed ...$messageParams): self
    {
        $this->message = format($message, ...$messageParams);

        return $this;
    }

    /**
     * Set code.
     *
     * @param  int|string $code
     * @return self
     */
    public function setCode(int|string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set file.
     *
     * @param  string $file
     * @return self
     */
    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Set line.
     *
     * @param  int $line
     * @return self
     */
    public function setLine(int $line): self
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @inheritDoc froq\common\interface\Thrownable
     */
    public function getCause(): Throwable|null
    {
        return $this->cause;
    }

    /**
     * @inheritDoc froq\common\interface\Thrownable
     */
    public function getCauses(): array
    {
        $ret = [];

        if ($cause = $this->getCause()) {
            $ret[] = $cause;

            while ($cause instanceof Thrownable && ($root = $cause?->getCause())) {
                $ret[] = $cause = $root;
            }
        }

        return $ret;
    }

    /**
     * @inheritDoc froq\common\interface\Thrownable
     */
    public function getState(): State|null
    {
        return $this->state;
    }

    /**
     * Get class name of user object.
     *
     * @return string
     */
    public function getName(): string
    {
        return get_class_name($this, escape: true);
    }

    /**
     * Get class of user object.
     *
     * @param  bool $short
     * @return string
     */
    public function getClass(bool $short = false): string
    {
        return get_class_name($this, $short, escape: true);
    }

    /**
     * Get type of user object.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->isError() ? 'error' : 'exception';
    }

    /**
     * Get a trace item by given index.
     *
     * @param  int $index
     * @return array|null
     */
    public function getTraceItem(int $index): array|null
    {
        return $this->getTrace()[$index] ?? null;
    }

    /**
     * Get trace stack.
     *
     * @return TraceStack|null
     */
    public function getTraceStack(): TraceStack|null
    {
        $ret = $this->getTrace();

        return $ret ? new TraceStack($ret) : null;
    }

    /**
     * Get a trace item by given index.
     *
     * @param  int $index
     * @return Trace|null
     */
    public function getTraceStackItem(int $index): Trace|null
    {
        $ret = $this->getTraceItem($index);

        return $ret ? new Trace($ret, $index) : null;
    }

    /**
     * Get trace path.
     *
     * @return array
     */
    public function getTracePath(): array
    {
        return Debugger::debugTracePath($this);
    }

    /**
     * Get trace string.
     *
     * @return string
     */
    public function getTraceString(): string
    {
        return Debugger::debugTraceString($this);
    }

    /**
     * Debug.
     *
     * @param  bool $withTrace
     * @param  bool $withTracePath
     * @param  bool $withTraceString
     * @param  bool $dots
     * @return array
     */
    public function debug(bool $withTrace = true, bool $withTracePath = false, bool $withTraceString = false,
        bool $dots = false): array
    {
        return Debugger::debug($this, $withTrace, $withTracePath, $withTraceString, $dots);
    }

    /**
     * Check user object whether instance of `Error`.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return ($this instanceof \Error);
    }

    /**
     * Check user object whether instance of `Exception`.
     *
     * @return bool
     */
    public function isException(): bool
    {
        return ($this instanceof \Exception);
    }

    /**
     * Get last internal error.
     *
     * @return array
     */
    protected static function lastError(): array
    {
        // Better calling when sure there is an error happened.
        $error = error_get_last();

        return [
            'code'    => $error['type']    ?? null,
            'message' => $error['message'] ?? 'Unknown'
        ];
    }

    /**
     * Extract a message dropping e.g. "RegexIterator::__construct():".
     *
     * @param  string|Throwable $e
     * @return string
     */
    protected static function extractMessage(string|Throwable $e): string
    {
        $ret = is_string($e) ? $e : $e->getMessage();

        if (strsrc($ret, '):')) {
            $ret = stracut($ret, '):');
        }

        return trim($ret);
    }

    /**
     * Apply "reduce" option that given in constructor. This option is useful
     * for creating throwable instances via methods or functions and dropping
     * this creation footprints from the stack trace.
     *
     * For example creating & throwing an error:
     *
     * ```
     * // Somewhere in UserError.
     * static function forInvalidId($id) {
     *   return new static('Invalid ID: ' . $id); // or
     *   // return new static('Invalid ID: ' . $id, reduce: true);
     * }
     *
     * // Somewhere in project.
     * if ($id < 0) {
     *   throw UserError::forInvalidId($id);
     * }
     * ```
     */
    private function applyReduce(int $reduce): void
    {
        if ($reduce > 0) {
            $traces = $this->getTrace();
            if (!$traces) {
                return;
            }

            // Reduce traces.
            while ($reduce--) {
                $trace = array_shift($traces);

                // Set file & line info to shifted trace.
                if (isset($trace['file'], $trace['line'])) {
                    $this->file = $trace['file'];
                    $this->line = $trace['line'];
                }
            }

            // Find base parent (so Error or Exception).
            $ref = new \ReflectionObject($this);
            while ($parent = $ref->getParentClass()) {
                $ref = $parent;
            }

            // Update trace property with changed traces as well.
            $ref->getProperty('trace')->setValue($this, $traces);
        }
    }

    /**
     * Prepare extra options that given in constructor as named parameters.
     */
    private function prepareOptions(array $options): array
    {
        return array_select($options,
            ['extract', 'lower', 'reduce', 'state'],
            [false, false, null, null]
        );
    }
}
