<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

use Throwable, Error, Exception;

/**
 * Throwable Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\AttributeTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait ThrowableTrait
{
    /**
     * Constructor.
     *
     * @param string|Throwable  $message
     * @param string|array|null $messageParams
     * @param int|null          $code
     * @param Throwable|null    $previous
     */
    public function __construct($message = null, $messageParams = null, int $code = null, Throwable $previous = null)
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
                elseif ($messageParams) {
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
            } elseif (is_object($message) && $message instanceof Throwable) {
                $code     = $code ?? $message->getCode();
                $previous = $previous ?? $message->getPrevious();
                $message  = $message->getMessage();
            } else {
                throw new Exception(sprintf(
                    "Invalid message type '%s' given to '%s', valids are: string, Throwable",
                    is_object($message) ? get_class($message) : gettype($message), static::class
                ));
            }
        }

        parent::__construct((string) $message, (int) $code, $previous);
    }

    /**
     * String magic.
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
     * Gets the class of.
     *
     * @return string
     */
    public function getClass(): string
    {
        return get_class($this);
    }

    /**
     * Gets the type of.
     *
     * @param  bool $short
     * @return string
     */
    public function getType(bool $short = false): string
    {
        $type = $this->getClass();

        if ($short && ($pos = strrpos($type, '\\'))) {
            $type = substr($type, $pos + 1);
        }

        return $type;
    }

    /**
     * Gets the trace string of (alias of getTraceAsString()).
     *
     * @return string
     */
    public function getTraceString(): string
    {
        return $this->getTraceAsString();
    }

    /**
     * Gets a string representation of.
     *
     * @param  bool $pretty
     * @return string
     */
    public function toString(bool $pretty = false): string
    {
        [$class, $code, $line, $file, $message, $messageTrace] = [
            $this->getClass(), $this->code, $this->line, $this->file,
            $this->getMessage(), $this->getTraceString()
        ];

        if ($pretty) {
            $file = str_replace('.php', '', $file);
            $class = str_replace('\\', '.', $class);

            // Change dotable stuffs and remove php extensions.
            $message = preg_replace(['~(\w)(?:\\\|::|->)(\w)~', '~\.php~'],
                ['\1.\2', ''], $message);
            $messageTrace = preg_replace_callback('~(?:\.php[(]|(?:\\\|::|->))~',
                fn($m) => ($m[0] == '.php(') ? '(' : '.', $messageTrace);
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
     * Checks the self object whether instance of Error or not.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return ($this instanceof Error);
    }

    /**
     * Checks the self object whether instance of Exception or not.
     *
     * @return bool
     */
    public function isException(): bool
    {
        return ($this instanceof Exception);
    }

    /**
     * Gets last internal error if exists.
     *
     * @return array<string, string|int>
     */
    public static final function getLastError(): array
    {
        // Better calling when sure there is an error happened.
        $error = error_get_last();

        return [
            'code'    => $error['type'] ?? null,
            'message' => strtolower($error['message'] ?? 'unknown')
        ];
    }
}
