<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * A trait, partly provides "sealed class" mechanism via `seal()` method.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\SealTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait SealTrait
{
    /**
     * Seal.
     *
     * Note: This method must be called in user's `__construct()` method
     * since cannot find a different way to check permission state, yet.
     *
     * @param  array $permits
     * @return void
     * @throws Error
     */
    private static function seal(array $permits): void
    {
        if (get_parent_class(static::class) != self::class) {
            return;
        }

        if (!in_array(static::class, $permits, true)) {
            throw new \Error(format(
                'Sealed class %s permits only %A, class %s cannot extend class %s',
                self::class, $permits, static::class, self::class
            ));
        }
    }
}
