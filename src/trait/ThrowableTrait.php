<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use Throwable, Error, Exception;

/**
 * Throwable Trait.
 *
 * A trait that is used by Error/Exception classes, provides a relaxation getting rid of
 * `sprintf()` calls for each throw also having some utility methods and cause option.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ThrowableTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait ThrowableTrait
{
    /** @var Throwable|null */
    private Throwable|null $cause;

    /**
     * Constructor.
     *
     * @param string|Throwable  $message
     * @param mixed|null        $messageParams
     * @param int|null          $code
     * @param Throwable|null    $previous
     * @param Throwable|null    $cause
     */
    public function __construct(string|Throwable $message = null, $messageParams = null, int $code = null,
        Throwable $previous = null, Throwable $cause = null)
    {
        if ($message != null) {
            if (is_string($message)) {
                // Eg: throw new Exception('@error').
                if ($message === '@error') {
                    $error    = self::getLastError();
                    $code     = $code ?? $error['code'];
                    $message  = 'Error: '. $error['message'];
                }
                // Eg: throw new Exception('Error: %s', ['The error!'] or ['@error']).
                elseif ($messageParams !== null) {
                    // Special formats (quoted string, int & error).
                    $message       = str_replace('%e', '@error', $message);
                    $messageParams = (array) $messageParams;

                    foreach ($messageParams as $i => $messageParam) {
                        if ($messageParam === '@error') {
                            $error             = self::getLastError();
                            $code              = $code ?? $error['code'];
                            $messageParams[$i] = $error['message'];
                            break;
                        }
                    }

                    // Special format for "@type/%t given" messages.
                    if (preg_test('~@type|%t~', $message)) {
                        $message = str_replace('@type', '%t', $message);

                        // Replace %t's & params with their types.
                        foreach (grep_all($message, '~(%[a-z])~') as $i => $op) {
                            if ($op == '%t') {
                                $message           = substr_replace($message, '%s', strpos($message, '%t'), 2);
                                $messageParams[$i] = get_type($messageParams[$i]);
                            }
                        }
                    }

                    $message = format($message, ...$messageParams);
                }
            } else {
                // Use message as previous.
                $previous ??= $message;

                $code     ??= $message->getCode();
                $message    = $message->getMessage();
            }
        }

        $this->cause = $cause;

        parent::__construct((string) $message, (int) $code, $previous);
    }

    /** @magic __get() */
    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        trigger_error(
            'Undefined property: '. $this::class .'::$'. $property,
            E_USER_WARNING // Act like original.
        );

        return null;
    }

    /** @magic __toString() */
    public function __toString(): string
    {
        // Eg: Exception: ... => Exception(404): ...
        return preg_replace('~^(.+?): *(.+)~', '\1('. $this->code .'): \2',
            parent::__toString());
    }

    /**
     * Get cause.
     *
     * @return Throwable|null
     * @since  5.0
     */
    public final function getCause(): Throwable|null
    {
        return $this->cause;
    }

    /**
     * Get causes.
     *
     * @return array<Throwable>|null
     * @since  5.0
     */
    public final function getCauses(): array|null
    {
        $causes = null;

        if ($cause = $this->getCause()) {
            $causes[] = $cause;

            while ($root = $cause?->getCause()) {
                $causes[] = $cause = $root;
            }
        }

        return $causes;
    }

    /**
     * Get root cause.
     *
     * @return Throwable|null
     * @since  5.0
     */
    public final function getRootCause(): Throwable|null
    {
        $cause = $this->getCause();

        while ($root = $cause?->getCause()) {
            $cause = $root;
        }

        return $cause;
    }

    /**
     * Get class name of user object.
     *
     * @return string
     */
    public final function getName(): string
    {
        return $this::class;
    }

    /**
     * Get class of user object.
     *
     * @param  bool $short
     * @return string
     */
    public final function getClass(bool $short = false): string
    {
        $class = $this::class;

        if ($short && ($pos = strrpos($class, '\\'))) {
            $class = substr($class, $pos + 1);
        }

        return $class;
    }

    /**
     * Get type of user object.
     *
     * @return string
     */
    public final function getType(): string
    {
        return $this->isError() ? 'error' : 'exception';
    }

    /**
     * Get the trace string of user object (alias of getTraceAsString()).
     *
     * @return string
     */
    public final function getTraceString(): string
    {
        return $this->getTraceAsString();
    }

    /**
     * Get a string representation of user object.
     *
     * @param  bool $pretty
     * @return string
     */
    public final function toString(bool $pretty = false): string
    {
        [$class, $code, $line, $file, $message, $messageTrace] = [
            $this->getClass(), $this->code, $this->line, $this->file,
            $this->getMessage(), $this->getTraceString()
        ];

        if ($pretty) {
            $file  = str_replace('.php', '', $file);
            $class = str_replace('\\', '.', $class);

            // Change dotable stuffs and remove php extensions.
            $message      = preg_replace(['~(\w)(?:\\\|::|->)(\w)~', '~\.php~'], ['\1.\2', ''], $message);
            $messageTrace = preg_replace_callback('~(?:\.php[(]|(?:\\\|::|->))~',
                fn($m) => $m[0] == '.php(' ? '(' : '.', $messageTrace);
        }

        return sprintf(
            "%s\n%s\n\n%s(%d): %s at %s:%d\n-\n%s",
            sprintf("%s.", trim($message, '.')),
            sprintf("Code: %d | Line: %d | File: %s", $code, $line, $file),
            $class, $code, $message,
            $file, $line, $messageTrace
        );
    }

    /**
     * Check user object whether instance of Error.
     *
     * @return bool
     */
    public final function isError(): bool
    {
        return ($this instanceof Error);
    }

    /**
     * Check user object whether instance of Exception.
     *
     * @return bool
     */
    public final function isException(): bool
    {
        return ($this instanceof Exception);
    }

    /**
     * Get last internal error if exists.
     *
     * @return array<string, string|int>
     */
    public static final function getLastError(): array
    {
        // Better calling when sure there is an error happened.
        $error = error_get_last();

        return [
            'code'    => $error['type']    ?? null,
            'message' => $error['message'] ?? 'unknown'
        ];
    }
}
