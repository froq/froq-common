<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\util\Objects;

/**
 * Method Trait.
 *
 * A trait, for objects and can be used with ObjectTrait, ConstantTrait and PropertyTrait.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\MethodTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait MethodTrait
{
    /**
     * Check whether a method exists on user object.
     *
     * @param  string $name
     * @return bool
     */
    public final function hasMethod(string $name): bool
    {
        return method_exists($this, $name);
    }

    /**
     * Get a detailed method info.
     *
     * @param  string $name
     * @return array|null
     */
    public final function getMethod(string $name): array|null
    {
        return Objects::getMethod($this, $name);
    }

    /**
     * Get methods.
     *
     * @param  bool $all
     * @return array|null
     */
    public final function getMethods(bool $all = true): array|null
    {
        return Objects::getMethods($this, $all);
    }

    /**
     * Get method names.
     *
     * @param  bool $all
     * @return array|null
     */
    public final function getMethodNames(bool $all = true): array|null
    {
        return Objects::getMethodNames($this, $all);
    }
}
