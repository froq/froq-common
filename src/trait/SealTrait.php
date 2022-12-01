<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, partly provides "sealed class" mechanism via `seal()` method.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\SealTrait
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
     * @param  string ...$permits List of allowed class names.
     * @return void
     * @throws Error
     */
    private static function seal(string ...$permits): void
    {
        if (get_parent_class(static::class) !== self::class) {
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
