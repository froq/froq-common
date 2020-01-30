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

use froq\Exception;

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
     * @param  bool   $replaceable
     * @return void
     * @throws froq\Exception
     */
    public static function set(string $id, object $object, bool $replaceable = false): void
    {
        $current = self::$stack[$id] ?? null;
        if ($current && $current['replaceable'] == false) {
            throw new Exception(sprintf('Object "%s" is already registered and not '.
                'replaceable, call replace() instead to force it to change.', $id));
        }

        self::register($id, $object, $replaceable);
    }

    /**
     * Get.
     * @param  string $id
     * @return object
     * @throws froq\Exception
     */
    public static function get(string $id): object
    {
        if (self::has($id)) {
            return self::$stack[$id]['object'];
        }

        throw new Exception(sprintf('Object "%s" is not exists in registry', $id));
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
     * @param  bool   $replaceable
     * @return void
     */
    public static function replace(string $id, object $object, bool $replaceable = false): void
    {
        self::register($id, $object, $replaceable);
    }

    /**
     * Register.
     * @param  string $id
     * @param  object $object
     * @param  bool   $replaceable
     * @return void
     * @internal
     */
    private static function register(string $id, object $object, bool $replaceable): void
    {
        self::$stack[$id] = ['object' => $object, 'replaceable' => $replaceable];
    }
}
