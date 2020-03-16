<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\common\objects;

use froq\common\Exception;
use ReflectionClass;

/**
 * Enum.
 *
 * Represents an enumerable set of named values.
 * We all wish it was a part of PHP but not (RFC: http://wiki.php.net/rfc/enum).
 *
 * @package froq\common\objects
 * @object  froq\common\objects\Enum
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Enum
{
    /**
     * Cache.
     * @var array
     */
    private static array $cache;

    /**
     * Value.
     * @var any
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param any $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Provides call routines such as "$foo->isBar()", that prefixed with `is`.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return bool
     * @throws froq\common\Exception
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'is') !== 0) {
            throw new Exception('No valid call as "%s::%s()", call must be prefixed with "is" '.
                'and followed by an existing constant name', [static::class, $name, __function__]);
        }

        $constants = self::toArray();

        $name = strtoupper(substr($name, 2));
        if (!array_key_exists($name, $constants)) {
            throw new Exception('No constant exists such "%s::%s"', [static::class, $name]);
        }

        return ($this->value === $constants[$name]);
    }

    /**
     * Provides static call routines such as "Foo::isBar()", that prefixed with `is`.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return bool
     * @throws froq\common\Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if (strpos($name, 'is') !== 0) {
            throw new Exception('No valid call as "%s::%s()", call must be prefixed with "is" '.
                'and followed by an existing constant name', [static::class, $name]);
        }

        $constants = self::toArray();

        $name = strtoupper(substr($name, 2));
        if (!array_key_exists($name, $constants)) {
            throw new Exception('No constant exists such "%s::%s"', [static::class, $name]);
        }
        if (!array_key_exists(0, $arguments)) {
            throw new Exception('No value given in arguments');
        }

        return ($arguments[0] === $constants[$name]);
    }

    /**
     * Gets all constant names.
     *
     * @return array<string>
     */
    public static final function getNames(): array
    {
        return array_keys(self::toArray());
    }

    /**
     * Gets all constant values.
     *
     * @return array<any>
     */
    public static final function getValues(): array
    {
        return array_values(self::toArray());
    }

    /**
     * Checks whether a name is valid or not.
     *
     * @param  string $name
     * @return bool
     */
    public static final function isValidName(string $name): bool
    {
        return in_array($name, self::getNames(), true);
    }

    /**
     * Checks whether a value is valid or not.
     *
     * @param  string $value
     * @param  bool   $strict
     * @return bool
     */
    public static final function isValidValue(string $value, bool $strict = true): bool
    {
        return in_array($value, self::getValues(), $strict);
    }

    /**
     * Generates a array copy of defined constants with key/value pairs.
     *
     * @return array<string, any>
     */
    public static final function toArray(): array
    {
        $class = static::class;

        return self::$cache[$class] ?? self::$cache[$class] = (
            (new ReflectionClass($class))->getConstants()
        );
    }

    /**
     * Generates a string copy of definer class with its constants.
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
