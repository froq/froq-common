<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\objects;

use froq\common\Exception;

/**
 * Factory.
 *
 * @package froq\common\objects
 * @object  froq\common\objects\Factory
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
final class Factory
{
    /**
     * Instances, singleton stack.
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
        if (!class_exists($class)) {
            throw new Exception("No class exists such '%s'", $class);
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
        if (!class_exists($class)) {
            throw new Exception("No class exists such '%s'", $class);
        }

        return self::$instances[$class] ??= new $class(...$classArgs);
    }
}
