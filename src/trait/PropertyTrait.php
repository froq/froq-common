<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

use froq\util\Objects;

/**
 * A trait, for objects and can be used with ObjectTrait, ConstantTrait and MethodTrait.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\PropertyTrait
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
    public function hasProperty(string $name): bool
    {
        return property_exists($this, $name);
    }

    /**
     * Get a detailed property info.
     *
     * @param  string $name
     * @return array|null
     */
    public function getProperty(string $name): array|null
    {
        return Objects::getProperty($this, $name);
    }

    /**
     * Get a property value.
     *
     * @param  string $name
     * @return mixed
     */
    public function getPropertyValue(string $name): mixed
    {
        return Objects::getPropertyValue($this, $name);
    }

    /**
     * Get properties.
     *
     * @param  bool $all
     * @return array|null
     */
    public function getProperties(bool $all = true): array|null
    {
        return Objects::getProperties($this, $all);
    }

    /**
     * Get property names.
     *
     * @param  bool $all
     * @return array|null
     */
    public function getPropertyNames(bool $all = true): array|null
    {
        return Objects::getPropertyNames($this, $all);
    }

    /**
     * Get property values.
     *
     * @param  bool $all
     * @param  bool $assoc
     * @return array|null
     */
    public function getPropertyValues(bool $all = true, bool $assoc = false): array|null
    {
        return Objects::getPropertyValues($this, $all, $assoc);
    }
}
