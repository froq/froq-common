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
 * Registry.
 * @package froq\common\objects
 * @object  froq\common\objects\Registry
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
            throw new Exception('Object "%s" is already registered and locked with id "%s", '.
                'call replace() instead to force it to change with set().',
                [get_class($current['object']), $id]);
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
