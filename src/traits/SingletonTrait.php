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

namespace froq\traits;

use ReflectionClass;

/**
 * Singleton Trait.
 * @package froq\traits
 * @object  froq\traits\SingletonTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0, 4.0
 */
trait SingletonTrait
{
    /**
     * Instances.
     * @var array<object>
     */
    private static array $__instances = [];

    /**
     * Forbids.
     * @note Do not define '__clone' or '__construct' methods as public if you want a single
     * sub-object. These methods ain't final here, so this trait could be used a base object
     * for its all sub-objects.
     */
    private function __construct() {}
    private function __clone() {}

    /**
     * Init.
     * @param  ... $arguments
     * @return object
     */
    public static final function init(...$arguments): object
    {
        $className = static::class;

        if (empty(self::$__instances[$className])) {
            // Init object without constructor and call constructor with initial arguments to
            // prevent error: "Access to non-public constructor of class ...". newInstance()
            // nor newInstanceArgs() cannot do that.
            $reflection = new ReflectionClass($className);
            $classInstance = $reflection->newInstanceWithoutConstructor();

            // prepare constructor to call
            $constructor = $reflection->getConstructor();
            $constructor->setAccessible(true);
            $constructor->invokeArgs($classInstance, $arguments);

            self::$__instances[$className] = $classInstance;
        }

        return self::$__instances[$className];
    }
}
