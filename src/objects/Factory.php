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

/**
 * Factory.
 * @package froq\common\objects
 * @object  froq\common\objects\Factory
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
final class Factory
{
    /**
     * Instances (singleton stack).
     * @var array<string, object>
     */
    private static array $instances = [];

    /**
     * Init.
     * @param  string $class
     * @param  ...    $classArgs
     * @return object
     * @throws froq\common\Exception
     */
    public static function init(string $class, ...$classArgs): object
    {
        if (!$class) {
            throw new Exception('Empty class name given');
        } elseif (!class_exists($class)) {
            throw new Exception('Non-existent class name "%s" given', [$class]);
        }

        return new $class(...$classArgs);
    }

    /**
     * Init single.
     * @param  string $class
     * @param  ...    $classArgs
     * @return object
     * @throws froq\common\Exception
     */
    public static function initSingle(string $class, ...$classArgs): object
    {
        if (!$class) {
            throw new Exception('Empty class name given');
        } elseif (!class_exists($class)) {
            throw new Exception('Non-existent class name "%s" given', [$class]);
        }

        return self::$instances[$class] ??= new $class(...$classArgs);
    }
}
