<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

use froq\util\Objects;

/**
 * Constant Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\ConstantTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait ConstantTrait
{
    /**
     * Has constant.
     * @param  string $name
     * @return bool
     */
    public final function hasConstant(string $name): bool
    {
        // Seems working for private/protected constants also due to called scope.
        return defined(static::class .'::'. $name);
    }

    /**
     * Get constant.
     * @param  string $name
     * @return ?array<string, any>
     */
    public final function getConstant(string $name): ?array
    {
        return Objects::getConstant($this, $name);
    }

    /**
     * Get constant value.
     * @param  string $name
     * @return any
     */
    public final function getConstantValue(string $name)
    {
        return Objects::getConstantValue($this, $name);
    }

    /**
     * Get constants.
     * @param  bool $all
     * @return ?array<string, array>
     */
    public final function getConstants(bool $all = true): ?array
    {
        return Objects::getConstants($this, $all);
    }

    /**
     * Get constant names.
     * @param  bool $all
     * @return ?array<string>
     */
    public final function getConstantNames(bool $all = true): ?array
    {
        return Objects::getConstantNames($this, $all);
    }

    /**
     * Get constant value.
     * @param  bool $all
     * @return ?array<int|string, any>
     */
    public final function getConstantValues(bool $all = true, bool $associative = false): ?array
    {
        return Objects::getConstantValues($this, $all, $associative);
    }
}
