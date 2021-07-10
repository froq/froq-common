<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\util\Objects;

/**
 * Constant Trait.
 *
 * Represents a trait entity for objects which may be used with ObjectTrait, PropertyTrait and MethodTrait.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ConstantTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait ConstantTrait
{
    /**
     * Check whether a constant exists on user object.
     *
     * @param  string $name
     * @return bool
     */
    public final function hasConstant(string $name): bool
    {
        // Seems working for private/protected constants also due to called scope.
        return defined(static::class .'::'. $name);
    }

    /**
     * Get a detailed constant info.
     *
     * @param  string $name
     * @return array<string, any>|null
     */
    public final function getConstant(string $name): array|null
    {
        return Objects::getConstant($this, $name);
    }

    /**
     * Get a constant value.
     *
     * @param  string $name
     * @return any
     */
    public final function getConstantValue(string $name)
    {
        return Objects::getConstantValue($this, $name);
    }

    /**
     * Get constants.
     *
     * @param  bool $all
     * @return array<string, array>|null
     */
    public final function getConstants(bool $all = true): array|null
    {
        return Objects::getConstants($this, $all);
    }

    /**
     * Get constant names.
     *
     * @param  bool $all
     * @return array<string>|null
     */
    public final function getConstantNames(bool $all = true): array|null
    {
        return Objects::getConstantNames($this, $all);
    }

    /**
     * Get constant values.
     *
     * @param  bool $all
     * @return array<int|string, any>|null
     */
    public final function getConstantValues(bool $all = true, bool $associative = false): array|null
    {
        return Objects::getConstantValues($this, $all, $associative);
    }
}
