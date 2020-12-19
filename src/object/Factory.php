<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\Exception;

/**
 * Factory.
 *
 * Represents a factory entity that creates instances from given class names (with arguments), and caches
 * using singleton way when requested.
 *
 * @package froq\common\object
 * @object  froq\common\object\Factory
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
final class Factory
{
    /**
     * Singleton stack.
     * @var array<string, object>
     */
    private static array $instances = [];

    /**
     * Create an instance from given class with its arguments.
     *
     * @param  string $class
     * @param  ...    $classArgs
     * @return object
     * @throws froq\common\Exception
     */
    public static function init(string $class, ...$classArgs): object
    {
        if (class_exists($class)) {
            return new $class(...$classArgs);
        }

        throw new Exception('No class exists such ' . $class);
    }

    /**
     * Create a single instance from given class with its arguments if it was not created previously.
     *
     * @param  string $class
     * @param  ...    $classArgs
     * @return object
     * @throws froq\common\Exception
     */
    public static function initSingle(string $class, ...$classArgs): object
    {
        if (class_exists($class)) {
            return self::$instances[$class] ??= new $class(...$classArgs);
        }

        throw new Exception('No class exists such ' . $class);
    }
}
