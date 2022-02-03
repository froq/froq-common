<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\interface\{Arrayable, Stringable};
use froq\util\Objects;
use ReflectionObject, ReflectionObjectExtended;

/**
 * X-Object.
 *
 * An abstract & extended object that provides couple of utility methods which access
 * and check object's attributes.
 *
 * @package froq\common\object
 * @object  froq\common\object\XObject
 * @author  Kerem Güneş
 * @since   4.0
 */
abstract class XObject implements Arrayable, Stringable
{
    /**
     * Reflect & return reflection
     *
     * @param  bool $extended
     * @return ReflectionObject|ReflectionObjectExtended
     */
    public final function reflect(bool $extended = false): ReflectionObject|ReflectionObjectExtended
    {
        return !$extended ? new ReflectionObject($this) : new ReflectionObjectExtended($this);
    }

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
     * @param  object|string $object
     * @return bool
     */
    public final function isInstanceOf(object|string $object): bool
    {
        return ($this instanceof $object);
    }

    /**
     * Is equal to.
     *
     * @param  object $object
     * @param  bool   $strict
     * @return bool
     */
    public final function isEqualTo(object $object, bool $strict = true): bool
    {
        return $strict ? ($this === $object) : ($this == $object);
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return get_class_properties($this, scope_check: true);
    }

    /**
     * @inheritDoc froq\common\interface\Stringable
     */
    public function toString(): string
    {
        $vars = get_class_properties($this, scope_check: false);
        [$objectType, $objectId] = split('#', Objects::getId($this));

        return sprintf('object(%d) <%s>#%s { %s }',
            count($vars), $objectType, $objectId, join(', ', array_keys($vars)));
    }
}
