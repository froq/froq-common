<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

/**
 * Registry.
 *
 * A registry class, able to store/unstore objects only.
 *
 * @package froq\common\object
 * @object  froq\common\object\Registry
 * @author  Kerem Güneş
 * @since   4.0
 */
final class Registry
{
    /** @var array<string, object> */
    private static array $stack = [];

    /**
     * Get stack property.
     *
     * @return array<string, object>
     */
    public static function stack(): array
    {
        return self::$stack;
    }

    /**
     * Check whether an object is in registry stack.
     *
     * @param  string $id
     * @return bool
     */
    public static function has(string $id): bool
    {
        return isset(self::$stack[$id]);
    }

    /**
     * Put an object into registry stack.
     *
     * @param  string $id
     * @param  object $object
     * @param  bool   $locked
     * @return void
     * @throws froq\common\object\RegistryException
     */
    public static function set(string $id, object $object, bool $locked = true): void
    {
        $current = self::$stack[$id] ?? null;

        if ($current && $current['locked']) {
            throw new RegistryException(
                'Object `%s` is already registered and locked with id `%s`, '.
                'call replace() instead to force it to change with set().',
                [$current['object']::class, $id]
            );
        }

        self::register($id, $object, $locked);
    }

    /**
     * Get an object from register stack if exists.
     *
     * @param  string $id
     * @return object|null
     */
    public static function get(string $id): object|null
    {
        return self::$stack[$id]['object'] ?? null;
    }

    /**
     * Remove a registered object from registry stack.
     *
     * @param  string $id
     * @return void
     */
    public static function remove(string $id): void
    {
        unset(self::$stack[$id]);
    }

    /**
     * Replace an object with new one.
     *
     * @param  string $id
     * @param  object $object
     * @param  bool   $locked
     * @return void
     */
    public static function replace(string $id, object $object, bool $locked = true): void
    {
        self::register($id, $object, $locked);
    }

    /**
     * Internal registry wrapper.
     */
    private static function register(string $id, object $object, bool $locked): void
    {
        self::$stack[$id] = ['object' => $object, 'locked' => $locked];
    }
}
