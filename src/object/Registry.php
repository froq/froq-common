<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\Exception;

/**
 * Registry.
 *
 * @package froq\common\object
 * @object  froq\common\object\Registry
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
final class Registry
{
    /**
     * Stack.
     * @var array<string, array>
     */
    private static array $stack = [];

    /**
     * Get stack.
     * @return array<string, array>
     */
    public static function getStack(): array
    {
        return self::$stack;
    }

    /**
     * Has.
     * @param  string $id
     * @return bool
     */
    public static function has(string $id): bool
    {
        return isset(self::$stack[$id]);
    }

    /**
     * Set.
     * @param  string $id
     * @param  object $object
     * @param  bool   $locked
     * @return void
     * @throws froq\common\Exception
     */
    public static function set(string $id, object $object, bool $locked = true): void
    {
        $current = self::$stack[$id] ?? null;

        if ($current && $current['locked']) {
            throw new Exception('Object `%s` is already registered and locked with id `%s`, call replace()'
                . ' instead to force it to change with set().', [$current['object']::class, $id]);
        }

        self::register($id, $object, $locked);
    }

    /**
     * Get.
     * @param  string $id
     * @return ?object
     * @throws froq\common\Exception
     */
    public static function get(string $id): ?object
    {
        return self::$stack[$id]['object'] ?? null;
    }

    /**
     * Remove.
     * @param  string $id
     * @return void
     */
    public static function remove(string $id): void
    {
        unset(self::$stack[$id]);
    }

    /**
     * Replace.
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
     * Register.
     * @param  string $id
     * @param  object $object
     * @param  bool   $locked
     * @return void
     */
    private static function register(string $id, object $object, bool $locked): void
    {
        self::$stack[$id] = ['object' => $object, 'locked' => $locked];
    }
}
