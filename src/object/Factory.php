<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

/**
 * Factory.
 *
 * A factory class that creates instances from given class names with/without arguments,
 * and caches using singleton way when requested.
 *
 * @package froq\common\object
 * @object  froq\common\object\Factory
 * @author  Kerem Güneş
 * @since   4.0
 */
class Factory
{
    /** @var array<string, object> */
    private static array $instances = [];

    /**
     * Create an instance from given class with/without its arguments.
     *
     * @param  string   $class
     * @param  mixed ...$classArgs
     * @return object
     * @throws froq\common\object\FactoryException
     */
    public static final function init(string $class, mixed ...$classArgs): object
    {
        if (class_exists($class)) {
            return new $class(...$classArgs);
        }

        throw new FactoryException('No class exists such ' . $class);
    }

    /**
     * Create an instance from given class as singleton with/without its arguments
     * and cache it or return cached one that was previously created.
     *
     * @param  string   $class
     * @param  mixed ...$classArgs
     * @return object
     * @throws froq\common\object\FactoryException
     */
    public static final function initOnce(string $class, mixed ...$classArgs): object
    {
        if (class_exists($class)) {
            return self::$instances[$class] ??= new $class(...$classArgs);
        }

        throw new FactoryException('No class exists such ' . $class);
    }
}
