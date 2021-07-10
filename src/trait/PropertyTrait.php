<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
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
 * @author  Kerem Güneş
 * @since   4.0
 */
trait PropertyTrait
{
    /**
     * Check whether a property exists on user object.
     *
     * @param  string $name
     * @return bool
     */
    public final function hasProperty(string $name): bool
    {
        return property_exists($this, $name);
    }

    /**
     * Get a detailed property info.
     *
     * @param  string $name
     * @return array<string, any>|null
     */
    public final function getProperty(string $name): array|null
    {
        return Objects::getProperty($this, $name);
    }

    /**
     * Get a property value.
     *
     * @param  string $name
     * @return any
     */
    public final function getPropertyValue(string $name)
    {
        return Objects::getPropertyValue($this, $name);
    }

    /**
     * Get properties.
     *
     * @param  bool $all
     * @return array<string, array>|null
     */
    public final function getProperties(bool $all = true): array|null
    {
        return Objects::getProperties($this, $all);
    }

    /**
     * Get property names.
     *
     * @param  bool $all
     * @return array<string>|null
     */
    public final function getPropertyNames(bool $all = true): array|null
    {
        return Objects::getPropertyNames($this, $all);
    }

    /**
     * Get property values.
     *
     * @param  bool $all
     * @return array<string>|null
     */
    public final function getPropertyValues(bool $all = true, bool $associative = false): array|null
    {
        return Objects::getPropertyValues($this, $all, $associative);
    }
}
