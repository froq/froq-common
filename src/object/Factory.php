<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\Exception;

/**
 * Factory.
 *
 * Represents a factory entity that creates instances from given class names with/without arguments, and caches
 * using singleton way when requested.
 *
 * @package froq\common\object
 * @object  froq\common\object\Factory
 * @author  Kerem Güneş
 * @since   4.0
 */
final class Factory
{
    /** @var array<string, object> */
    private static array $instances = [];

    /**
     * Create an instance from given class with/without its arguments.
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
     * Create an instance from given class as singleton with/without its arguments and cache it or return
     * cached one that was previously created.
     *
     * @param  string $class
     * @param  ...    $classArgs
     * @return object
     * @throws froq\common\Exception
     */
    public static function initOnce(string $class, ...$classArgs): object
    {
        if (class_exists($class)) {
            return self::$instances[$class] ??= new $class(...$classArgs);
        }

        throw new Exception('No class exists such ' . $class);
    }
}
