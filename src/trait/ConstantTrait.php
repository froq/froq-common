<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

use froq\util\Objects;

/**
 * A trait, for objects and can be used with ObjectTrait, PropertyTrait and MethodTrait.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\ConstantTrait
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
    public function hasConstant(string $name): bool
    {
        return constant_exists($this, $name);
    }

    /**
     * Get a detailed constant info.
     *
     * @param  string $name
     * @return array|null
     */
    public function getConstant(string $name): array|null
    {
        return Objects::getConstant($this, $name);
    }

    /**
     * Get a constant value.
     *
     * @param  string $name
     * @return mixed
     */
    public function getConstantValue(string $name): mixed
    {
        return Objects::getConstantValue($this, $name);
    }

    /**
     * Get constants.
     *
     * @param  bool $all
     * @return array|null
     */
    public function getConstants(bool $all = true): array|null
    {
        return Objects::getConstants($this, $all);
    }

    /**
     * Get constant names.
     *
     * @param  bool $all
     * @return array|null
     */
    public function getConstantNames(bool $all = true): array|null
    {
        return Objects::getConstantNames($this, $all);
    }

    /**
     * Get constant values.
     *
     * @param  bool $all
     * @param  bool $assoc
     * @return array|null
     */
    public function getConstantValues(bool $all = true, bool $assoc = false): array|null
    {
        return Objects::getConstantValues($this, $all, $assoc);
    }
}
