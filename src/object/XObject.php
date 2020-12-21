<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\interface\Stringable;
use froq\util\Objects;
use ReflectionObject;

/**
 * X-Object.
 *
 * Represents an abstract but extended object that provides couple of utility methods which access and
 * check object's attributes.
 *
 * @package froq\common\object
 * @object  froq\common\object\XObject
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
abstract class XObject implements Stringable
{
    /**
     * Get name.
     *
     * @return string
     */
    public final function getName(): string
    {
        return Objects::getName($this);
    }

    /**
     * Get short name.
     *
     * @return string
     */
    public final function getShortName(): string
    {
        return Objects::getShortName($this);
    }

    /**
     * Get namespace.
     *
     * @param  bool $baseOnly
     * @return string
     */
    public final function getNamespace(bool $baseOnly = false): string
    {
        return Objects::getNamespace($this, $baseOnly);
    }

    /**
     * Get reflection.
     *
     * @return ReflectionObject
     */
    public final function getReflection(): ReflectionObject
    {
        return new ReflectionObject($this);
    }

    /**
     * Get constants.
     *
     * @param  bool $all
     * @return array<string, array>|null
     * @since  5.0
     */
    public final function getConstants(bool $all = true): array|null
    {
        return Objects::getConstants($this, $all);
    }

    /**
     * Get properties.
     *
     * @param  bool $all
     * @return array<string, array>|null
     * @since  5.0
     */
    public final function getProperties(bool $all = true): array|null
    {
        return Objects::getProperties($this, $all);
    }

    /**
     * Get methods.
     *
     * @param  bool $all
     * @return array<string, array>|null
     * @since  5.0
     */
    public final function getMethods(bool $all = true): array|null
    {
        return Objects::getMethods($this, $all);
    }

    /**
     * Is type of.
     *
     * @param  string $class
     * @return bool
     */
    public final function isTypeOf(string $class): bool
    {
        return (static::class == $class);
    }

    /**
     * Is type of self.
     *
     * @return bool
     */
    public final function isTypeOfSelf(): bool
    {
        return (static::class == self::class);
    }

    /**
     * Is instance of.
     *
     * @param  string|object $class
     * @return bool
     */
    public final function isInstanceOf(string|object $class): bool
    {
        return ($this instanceof $class);
    }

    /**
     * Is equal to.
     *
     * @param  object $object
     * @param  bool   $strict
     * @return bool
     */
    public final function isEqualTo(object $object, bool $strict = false): bool
    {
        return !$strict ? ($this == $object) : ($this === $object);
    }

    /**
     * @inheritDoc froq\common\interface\Stringable
     */
    public function toString(): string
    {
        $vars = get_class_properties($this, scope_check: false);

        return sprintf('object(%s)#%s (%s) { %s }', $this->getName(), spl_object_id($this),
            count($vars), join(', ', array_keys($vars)));
    }
}
