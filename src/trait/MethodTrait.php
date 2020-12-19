<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\util\Objects;

/**
 * Method Trait.
 *
 * Represents a trait entity for objects which may be used with ObjectTrait, ConstantTrait and PropertyTrait.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\MethodTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait MethodTrait
{
    /**
     * Has method.
     * @param  string $name
     * @return bool
     */
    public final function hasMethod(string $name): bool
    {
        return method_exists($this, $name);
    }

    /**
     * Get method.
     * @param  string $name
     * @return ?array<string, any>
     */
    public final function getMethod(string $name): ?array
    {
        return Objects::getMethod($this, $name);
    }

    /**
     * Get methods.
     * @param  bool $all
     * @return ?array<string, array>
     */
    public final function getMethods(bool $all = true): ?array
    {
        return Objects::getMethods($this, $all);
    }

    /**
     * Get method names.
     * @param  bool $all
     * @return ?array<string>
     */
    public final function getMethodNames(bool $all = true): ?array
    {
        return Objects::getMethodNames($this, $all);
    }
}
