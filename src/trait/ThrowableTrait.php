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
 * Represents a trait entity which is used by Error and Exception classes, provides a relaxation getting
 * rid of `sprintf()` calls for each throw also having some utility methods and cause option.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\AttributeTrait
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
     * @param any|null          $messageParams
     * @param int|null          $code
     * @param Throwable|null    $cause
     * @param Throwable|null    $previous
     */
    public function __construct(string|Throwable $message = null, $messageParams = null, int $code = null,
        Throwable $cause = null, Throwable $previous = null)
    {
        if ($message != null) {
            if (is_string($message)) {
                // Eg: throw new Exception('@error').
                if ($message === '@error') {
                    $error         = self::getLastError();
                    $code          = $code ?? $error['code'];
                    $messageParams = [$error['message']];
                    $message = vsprintf('Error: %s', $messageParams);
                }
                // Eg: throw new Exception('Error: %s', ['The error!'] or ['@error']).
                elseif ($messageParams !== null) {
                    $messageParams = (array) $messageParams;

                    foreach ($messageParams as $i => $messageParam) {
                        if ($messageParam === '@error') {
                            $error             = self::getLastError();
                            $code              = $code ?? $error['code'];
                            $messageParams[$i] = $error['message'];
                            break;
                        }
                    }

                    $message = vsprintf($message, $messageParams);
                }
            } else {
                $code     ??= $message->getCode();
                $previous ??= $message->getPrevious() ?: $message; // Use message as previous.
                $message    = $message->getMessage();
            }
        }

        $this->cause = $cause;

        parent::__construct((string) $message, (int) $code, $previous);
    }

    /**
     * Magic - string.
     *
     * @return string
     */
    public function __toString()
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
