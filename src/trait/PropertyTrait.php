<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\util\Objects;

/**
 * Property Trait.
 *
 * Represents a trait entity for objects which may be used with ObjectTrait, ConstantTrait and MethodTrait.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\PropertyTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait PropertyTrait
{
    /**
     * Has property.
     * @param  string $name
     * @return bool
     */
    public final function hasProperty(string $name): bool
    {
        return property_exists($this, $name);
    }

    /**
     * Get property.
     * @param  string $name
     * @return ?array<string, any>
     */
    public final function getProperty(string $name): ?array
    {
        return Objects::getProperty($this, $name);
    }

    /**
     * Get property value.
     * @param  string $name
     * @return any
     */
    public final function getPropertyValue(string $name)
    {
        return Objects::getPropertyValue($this, $name);
    }

    /**
     * Get properties.
     * @param  bool $all
     * @return ?array<string, array>
     */
    public final function getProperties(bool $all = true): ?array
    {
        return Objects::getProperties($this, $all);
    }

    /**
     * Get property names.
     * @param  bool $all
     * @return ?array<string>
     */
    public final function getPropertyNames(bool $all = true): ?array
    {
        return Objects::getPropertyNames($this, $all);
    }

    /**
     * Get property values.
     * @param  bool $all
     * @return ?array<string>
     */
    public final function getPropertyValues(bool $all = true, bool $associative = false): ?array
    {
        return Objects::getPropertyValues($this, $all, $associative);
    }
}
