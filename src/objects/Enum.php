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
     * All.
     * @return array<string, any>
     */
    public static function all(): array
    {
        $class = static::class;

        return self::$cache[$class] ?? (
               self::$cache[$class] = (new ReflectionClass($class))->getConstants()
        );
    }

    /**
     * Names.
     * @return array<string>
     */
    public static function names(): array
    {
        return array_keys(self::all());
    }

    /**
     * Values.
     * @return array<any>
     */
    public static function values(): array
    {
        return array_values(self::all());
    }
}
