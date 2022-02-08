<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

/**
 * Enum.
 *
 * An enumerable set of named values, not just like internal "enum" but a bit extended.
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

    /** @var int|float|string|bool|array|null */
    protected int|float|string|bool|array|null $value;

    /**
     * Constructor.
     *
     * @param int|float|string|bool|array|null $value
     */
    public function __construct(int|float|string|bool|array|null $value = null)
    {
        $this->value = $value;
    }

    /**
     * @magic
     * @throws froq\common\object\EnumException
     */
    public function __toString(): string
    {
        if (is_array($this->value)) {
            throw new EnumException('Cannot cast array value to string');
        }

        return (string) $this->value;
    }

    /**
     * Provides call routines such as "$foo->isBar()", that prefixed with "is".
     *
     * @magic
     * @param  string $name
     * @param  array  $arguments
     * @return bool
     * @throws froq\common\object\EnumException
     */
    public function __call(string $name, array $arguments): bool
    {
        if (!str_starts_with($name, 'is') || strlen($name) == 2) {
            throw new EnumException(
                'No valid call as %s::%s(), call must be prefixed '.
                'with `is` and followed by an existing constant name',
                [static::class, $name]
            );
        }

        $constant  = strtoupper(substr($name, 2));
        $constants = self::toArray();

        if (!array_key_exists($constant, $constants)) {
            throw new EnumException(
                'No constant exists such %s::%s',
                [static::class, $constant]
            );
        }

        return ($this->value === $constants[$constant]);
    }

    /**
     * Provides static call routines such as "Foo::isBar()", that prefixed with "is".
     *
     * @magic
     * @param  string $name
     * @param  array  $arguments
     * @return bool
     * @throws froq\common\object\EnumException
     */
    public static function __callStatic(string $name, array $arguments): bool
    {
        if (!str_starts_with($name, 'is') || strlen($name) == 2) {
            throw new EnumException(
                'No valid call as %s::%s(), call must be prefixed '.
                'with `is` and followed by an existing constant name',
                [static::class, $name]
            );
        }

        $constant  = strtoupper(substr($name, 2));
        $constants = self::toArray();

        if (!array_key_exists($constant, $constants)) {
            throw new EnumException(
                'No constant exists such %s::%s',
                [static::class, $constant]
            );
        }
        if (!array_key_exists(0, $arguments)) {
            throw new EnumException('No value given in arguments');
        }

        return ($arguments[0] === $constants[$constant]);
    }

    /**
     * Set/get value.
     *
     * @param  int|float|string|bool|array|null $value
     * @return int|float|string|bool|array|null
     * @since  5.0
     */
    public function value(int|float|string|bool|array|null $value = null): int|float|string|bool|array|null
    {
        if (func_num_args()) {
            $this->setValue($value);
        }

        return $this->getValue();
    }

    /**
     * Set value.
     *
     * @param  int|float|string|bool|array|null $value
     * @return void
     */
    public function setValue(int|float|string|bool|array|null $value): void
    {
        $this->value = $value;
    }

    /**
     * Get value.
     *
     * @return int|float|string|bool|array|null
     */
    public function getValue(): int|float|string|bool|array|null
    {
        return $this->value;
    }

    /**
     * Get all constant names.
     *
     * @return array<string>
     */
    public static final function names(): array
    {
        return array_keys(self::toArray());
    }

    /**
     * Get all constant values.
     *
     * @return array<int|float|string|bool|array|null>
     */
    public static final function values(): array
    {
        return array_values(self::toArray());
    }

    /**
     * Get all constant entries.
     *
     * @return array<array<int|float|string|bool|array|null>>
     * @since  5.0
     */
    public static final function entries(): array
    {
        return array_entries(self::toArray());
    }

    /**
     * Check whether a name is valid.
     *
     * @param  string $name
     * @param  bool   $upper
     * @return bool
     */
    public static final function validName(string $name, bool $upper = false): bool
    {
        $upper && $name = strtoupper($name);

        return in_array($name, self::names(), true);
    }

    /**
     * Check whether a value is valid.
     *
     * @param  int|float|string|bool|array|null $value
     * @return bool
     */
    public static final function validValue(int|float|string|bool|array|null $value): bool
    {
        return in_array($value, self::values(), true);
    }

    /**
     * Get a name of value or return null when no value exists.
     *
     * @param  int|float|string|bool|array|null $value
     * @param  bool                             $lower
     * @return string|null
     * @since  4.7
     */
    public static final function nameOf(int|float|string|bool|array|null $value, bool $lower = false): string|null
    {
        $name = array_search($value, self::toArray(), true);

        if ($lower && $name) {
            $name = strtolower($name);
        }

        return ($name !== false) ? $name : null;
    }

    /**
     * Get value of a name or return null when no name exists.
     *
     * @param  string $name
     * @param  bool   $upper
     * @return int|float|string|bool|array|null|null
     * @since  4.7
     */
    public static final function valueOf(string $name, bool $upper = false): int|float|string|bool|array|null
    {
        if ($upper) {
            $name = strtoupper($name);
        }

        return self::toArray()[$name] ?? null;
    }

    /**
     * Generate an array copy of defined constants with key/value pairs or return cacheed one.
     *
     * @return array<string, int|float|string|bool|array|null>
     */
    public static final function toArray(): array
    {
        return self::$cache[static::class] ??= (
            (new \ReflectionClass(static::class))->getConstants()
        );
    }

    /**
     * Generate a string copy of definer class with its constants.
     *
     * @return string
     */
    public static final function toString(): string
    {
        $ret = "Enum(" . static::class . ") {\n";

        foreach (self::toArray() as $name => $value) {
            $ret .= "  {$name} ";
            if (is_null($value) || is_scalar($value)) {
                $ret .=  "= " . var_export($value, true) . "\n";
            } elseif (is_array($value)) {
                $values = [];
                foreach ($value as $k => $v) {
                    is_int($k) ? $values[] = "{$v}"
                               : $values[] = "'{$k}' => {$v}";
                }
                $ret .=  "= [" . join(", ", $values) . "]\n";
            }
        }

        $ret .= "}";

        return $ret;
    }
}
