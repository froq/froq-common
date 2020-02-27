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
     * Get names.
     * @return array<string>
     */
    public static final function getNames(): array
    {
        return array_keys(self::toArray());
    }

    /**
     * Get values.
     * @return array<any>
     */
    public static final function getValues(): array
    {
        return array_values(self::toArray());
    }

    /**
     * Is valid name.
     * @param  string $name
     * @return bool
     */
    public static final function isValidName(string $name): bool
    {
        return in_array($name, self::getNames(), true);
    }

    /**
     * Is valid value.
     * @param  string $value
     * @param  bool   $strict
     * @return bool
     */
    public static final function isValidValue(string $value, bool $strict = true): bool
    {
        return in_array($value, self::getValues(), $strict);
    }

    /**
     * To array.
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
     * To string.
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
