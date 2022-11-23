<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\common\{Error, Exception};
use Throwable, Trace, TraceEntry;

/**
 * A trait, used by Error/Exception classes, provides a relaxation getting rid of
 * `sprintf()` calls for each throw, has some utility methods and cause property
 * as well.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ThrowableTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait ThrowableTrait
{
    /** @var ?Throwable */
    private ?Throwable $cause = null;

    /** @var ?int */
    private ?int $reduce = null;

    /**
     * Constructor.
     *
     * @param string|Throwable|null $message
     * @param mixed|null            $messageParams
     * @param int|null              $code
     * @param Throwable|null        $previous
     * @param Throwable|null        $cause
     * @param int|bool|null         $reduce @todo Use "true" type.
     * @param bool|null             $extract
     */
    public function __construct(string|Throwable $message = null, mixed $messageParams = null, int $code = null,
        Throwable $previous = null, Throwable $cause = null, int|bool $reduce = null, bool $extract = null)
    {
        if ($message) {
            if (is_string($message)) {
                $error = self::getLastError();

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
                $cause   ??= $message;
                $code    ??= $message->getCode();
                $message   = $message->getMessage();
            }

            // Drop eg: "RegexIterator::__construct():" part.
            $extract && $message = self::extractMessage($message);
        }

        parent::__construct((string) $message, (int) $code, $previous);

        // Try to detect that this created via some static::for*() method.
        // Eg: if ($id < 0) throw UserError::forInvalidID($id).
        if ($reduce === null) {
            $trace =@ $this->getTrace()[0];
            if (isset($trace['class'], $trace['function'])
                && is_class_of($trace['class'], Throwable::class)
                && str_starts_with($trace['function'], 'for')) {
                $reduce = 1;
            }
        }

        $this->cause  = $cause;
        $this->reduce = (int) $reduce;

        $this->applyReduce();
    }

    /** @magic */
    public function __get(string $property): mixed
    {
        switch ($property) {
            case 'trace':
                return $this->getTrace();
            case 'traceString':
                return $this->getTraceString();
            case 'cause':
                return $this->getCause();
        }

        if (property_exists($this, $property)) {
            try {
                return $this->$property;
            } catch (Throwable) {
                // If subclasses define the property as "private".
                $ref = new \ReflectionProperty($this, $property);
                return $ref->isInitialized($this) ? $ref->getValue($this) : $ref->getDefaultValue();
            }
        }

        // Act as original.
        $message = sprintf('Undefined property: %s::$%s', $this::class, $property);
        trigger_error($message, E_USER_WARNING);

        return null;
    }

    /** @magic */
    public function __toString(): string
    {
        // Must call here/first for reduce since reduce
        // option changes file & line in applyReduce().
        $trace = $this->getTraceString();

        $ret = sprintf(
            "%s(%d): %s in %s:%d\nTrace:\n%s",
            $this->getClass(), $this->getCode(), $this->getMessage(),
            $this->getFile(), $this->getLine(), $trace
        );

        // Add cause info.
        if ($cause = $this->getCause()) {
            $ret .= "\n\n". 'Cause:' . "\n" . $cause;
        }

        return $ret;
    }

    /**
     * Get cause.
     *
     * @return Throwable|null
     * @since  5.0
     */
    public function getCause(): Throwable|null
    {
        return $this->cause;
    }

    /**
     * Get causes.
     *
     * @return array<Throwable>|null
     * @since  5.0
     */
    public function getCauses(): array|null
    {
        if ($cause = $this->getCause()) {
            $causes[] = $cause;

            while (is_class_of($cause, Error::class, Exception::class)
                && ($root = $cause?->getCause())) {
                $causes[] = $cause = $root;
            }
        }

        return $causes ?? null;
    }

    /**
     * Get root cause.
     *
     * @return Throwable|null
     * @since  5.0
     */
    public function getRootCause(): Throwable|null
    {
        if ($cause = $this->getCause()) {
            while (is_class_of($cause, Error::class, Exception::class)
                && ($root = $cause?->getCause())) {
                $cause = $root;
            }
        }

        return $cause;
    }

    /**
     * Get class name of user object.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this::class;
    }

    /**
     * Get class of user object.
     *
     * @param  bool $short
     * @return string
     */
    public function getClass(bool $short = false): string
    {
        $class = get_class_name($this::class, short: $short);
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
     * Get a trace by given index.
     *
     * @param  int $index
     * @return array|null
     */
    public function getTraceAt(int $index): array|null
    {
        return $this->getTrace()[$index] ?? null;
    }

    /**
     * Get a trace entry by given index.
     *
     * @param  int $index
     * @return TraceEntry|null
     */
    public function getTraceEntry(int $index): TraceEntry|null
    {
        $ret = $this->getTraceAt($index);

        return $ret ? new TraceEntry($ret, $index) : null;
    }

    /**
     * Get all trace entries.
     *
     * @return Trace|null
     */
    public function getTraceEntries(): Trace|null
    {
        $ret = $this->getTrace();

        return $ret ? new Trace($ret) : null;
    }

    /**
     * Get trace string.
     *
     * @return string
     */
    public function getTraceString(): string
    {
        $ret = $this->getTraceEntries();

        // Act as original.
        $ret ??= '#0 {main}';

        return (string) $ret;
    }

    /**
     * Get array representation.
     *
     * @param  bool $string
     * @return array
     */
    public function toArray(bool $string = false): array
    {
        return [
            'message' => $this->getMessage(), 'code' => $this->getCode(),
            'file' => $this->getFile(), 'line' => $this->getLine(),
            'class' => $this->getClass(), 'trace' => $this->getTrace(),
            'traceString' => $string ? $this->getTraceString() : null,
        ];
    }

    /**
     * Get string representation with some details.
     *
     * @param  bool $pretty
     * @return string
     */
    public function toString(bool $pretty = false): string
    {
        // Must call here/first for reduce since reduce
        // option changes file & line in applyReduce().
        $trace = $this->getTraceString();

        [$class, $code, $file, $line, $message] = [
            $this->getClass(), $this->getCode(),
            $this->getFile(), $this->getLine(),
            $this->getMessage(),
        ];

        if ($pretty) {
            $file  = str_replace('.php', '', $file);
            $class = str_replace('\\', '.', $class);

            // Change dotable stuff and remove php extensions.
            $message = preg_replace(['~(\w)(?:\\\|::|->)(\w)~', '~\.php~'], ['\1.\2', ''], $message);
            $trace   = preg_replace_callback('~(?:\.php[(]|(?:\\\|::|->))~',
                fn($m) => $m[0] == '.php(' ? '(' : '.', $trace);
        }

        $messageLine = $message ? trim($message, '.') . ".\n" : '';
        $detailsLine = sprintf("Class: %s | Code: %d | File: %s | Line: %d\n", $class, $code, $file, $line);

        return sprintf(
            "%s%s\n%s(%d): %s at %s:%d\n-\n%s",
            $messageLine, $detailsLine,
            $class, $code, $message,
            $file, $line, $trace
        );
    }

    /**
     * Check user object whether instance of Error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return ($this instanceof \Error);
    }

    /**
     * Check user object whether instance of Exception.
     *
     * @return bool
     */
    public function isException(): bool
    {
        return ($this instanceof \Exception);
    }

    /**
     * Get last internal error if exists.
     *
     * @return array
     */
    public static function getLastError(): array
    {
        // Better calling when sure there is an error happened.
        $error = error_get_last();

        return [
            'code'    => $error['type']    ?? null,
            'message' => $error['message'] ?? 'unknown'
        ];
    }

    /**
     * Extract a message dropping e.g. "RegexIterator::__construct():".
     *
     * @param  string|Throwable $e
     * @return string
     */
    public static function extractMessage(string|Throwable $e): string
    {
        $message = is_string($e) ? $e : $e->getMessage();

        if (strsrc($message, '):')) {
            $message = stracut($message, '):');
        }

        return trim($message);
    }

    /**
     * Apply "reduce" option that given via constructor. This option is useful
     * for creating throwable instances via methods or functions and dropping
     * this creation footprints from the stack trace.
     *
     * For example creating & throwing an error:
     *
     * ```
     * // Somewhere in UserError.
     * static function forInvalidID($id) {
     *   return new static('Invalid ID: ' . $id); // or
     *   // return new static('Invalid ID: ' . $id, reduce: true);
     * }
     *
     * // Somewhere in project.
     * if ($id < 0) {
     *   throw UserError::forInvalidID($id);
     * }
     * ```
     */
    private function applyReduce(): void
    {
        if ($this->reduce > 0) {
            $traces = $this->getTrace();

            // Reduce traces.
            while ($this->reduce--) {
                $trace = array_shift($traces);

                // Set file & line info to shifted trace.
                if (isset($trace['file'], $trace['line'])) {
                    $this->file = $trace['file'];
                    $this->line = $trace['line'];
                }
            }

            // Find base/top parent (so Error or Exception).
            $ref = new \ReflectionObject($this);
            while ($parent = $ref->getParentClass()) {
                $ref = $parent;
            }

            // Update trace property with changed traces as well.
            $ref->getProperty('trace')->setValue($this, $traces);
        }
    }
}
