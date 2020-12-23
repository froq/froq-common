<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\Exception;
use ReflectionClass;

/**
 * Enum.
 *
 * Represents an enumerable set of named values. We wish it was part of PHP but not (http://wiki.php.net/rfc/enum).
 *
 * @package froq\common\object
 * @object  froq\common\object\Enum
 * @author  Kerem Güneş
 * @since   4.0
 */
class Enum
{
    /** @var array */
    private static array $cache;

    /** @var any|null */
    protected $value;

    /**
     * Constructor.
     *
     * @param any|null $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * Magic - string: get value as string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * Magic - call: provide call routines such as "$foo->isBar()", that prefixed with "is".
     *
     * @param  string $name
     * @param  array  $arguments
     * @return bool
     * @throws froq\common\Exception
     */
    public function __call($name, $arguments)
    {
        if (!str_starts_with($name, 'is')) {
            throw new Exception('No valid call as %s::%s(), call must be prefixed with `is` and'
                . ' followed by an existing constant name', [static::class, $name, __function__]);
        }

        $constants = self::toArray();

        $name = strtoupper(substr($name, 2));
        if (!array_key_exists($name, $constants)) {
            throw new Exception('No constant exists such %s::%s', [static::class, $name]);
        }

        return ($this->value === $constants[$name]);
    }

    /**
     * Magic - call static: provide static call routines such as "Foo::isBar()", that prefixed with "is".
     *
     * @param  string $name
     * @param  array  $arguments
     * @return bool
     * @throws froq\common\Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if (!str_starts_with($name, 'is')) {
            throw new Exception('No valid call as %s::%s(), call must be prefixed with `is` and'
                . ' followed by an existing constant name', [static::class, $name]);
        }

        $constants = self::toArray();

        $name = strtoupper(substr($name, 2));
        if (!array_key_exists($name, $constants)) {
            throw new Exception('No constant exists such %s::%s', [static::class, $name]);
        }
        if (!array_key_exists(0, $arguments)) {
            throw new Exception('No value given in arguments');
        }

        return ($arguments[0] === $constants[$name]);
    }

    /**
     * Set value.
     *
     * @param  any $value
     * @return void
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * Get value.
     *
     * @return any|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get all constant names.
     *
     * @return array<string>
     */
    public static final function getNames(): array
    {
        return array_keys(self::toArray());
    }

    /**
     * Get all constant values.
     *
     * @return array<any>
     */
    public static final function getValues(): array
    {
        return array_values(self::toArray());
    }

    /**
     * Check whether a name is valid.
     *
     * @param  string $name
     * @return bool
     */
    public static final function isValidName(string $name): bool
    {
        return in_array($name, self::getNames(), true);
    }

    /**
     * Check whether a value is valid.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public static final function isValidValue($value, bool $strict = true): bool
    {
        return in_array($value, self::getValues(), $strict);
    }

    /**
     * Get a name of value or return null when no value exists.
     *
     * @param  any $value
     * @return string|null
     * @since  4.7
     */
    public static final function getNameOf($value)
    {
        $name = array_search($value, self::toArray(), true);

        return ($name !== false) ? $name : null;
    }

    /**
     * Get value of a name or return null when no name exists.
     *
     * @param  string $name
     * @return any|null
     * @since  4.7
     */
    public static final function getValueOf(string $name)
    {
        return self::toArray()[$name] ?? null;
    }

    /**
     * Generate an array copy of defined constants with key/value pairs or return cacheed one.
     *
     * @return array<string, any>
     */
    public static final function toArray(): array
    {
        return self::$cache[static::class] ??= (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Generate a string copy of definer class with its constants.
     *
     * @return string
     */
    public static final function toString(): string
    {
        $ret = "Enum(". static::class .") {\n";

        foreach (self::toArray() as $name => $value) {
            $ret .= "  {$name} ";
            if (is_null($value) || is_scalar($value)) {
                $ret .=  "= ". var_export($value, true) ."\n";
            } elseif (is_array($value)) {
                $values = "";
                foreach ($value as $k => $v) {
                    is_int($k) ? $values .= "{$v}, "
                               : $values .= "'{$k}' => {$v}, ";
                }
                $ret .=  "= [". trim($values, ", ") ."]\n";
            }
        }

        $ret .= "}";

        return $ret;
    }
}
