<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\util\Objects;
use ReflectionObject, XReflectionObject;

/**
 * A trait, for objects and can be used with ConstantTrait, PropertyTrait and MethodTrait.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ObjectTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait ObjectTrait
{
    /**
     * Reflect & return reflection.
     *
     * @param  bool $extended
     * @return ReflectionObject|XReflectionObject
     */
    public function reflect(bool $extended = false): ReflectionObject|XReflectionObject
    {
        return !$extended ? new ReflectionObject($this) : new XReflectionObject($this);
    }

    /**
     * Get id.
     *
     * @param  bool $withName
     * @return string
     */
    public function getId(bool $withName = true): string
    {
        return Objects::getId($this, $withName);
    }

    /**
     * Get hash.
     *
     * @param  bool $withName
     * @param  bool $withRehash
     * @return string
     */
    public function getHash(bool $withName = true, bool $withRehash = false): string
    {
        return Objects::getHash($this, $withName, $withRehash);
    }

    /**
     * Get serialized hash.
     *
     * @param  bool $withName
     * @return string
     */
    public function getSerializedHash(bool $withName = true): string
    {
        return Objects::getSerializedHash($this, $withName);
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return Objects::getName($this);
    }

    /**
     * Get short name.

     * @return string
     */
    public function getShortName(): string
    {
        return Objects::getShortName($this);
    }

    /**
     * Get namespace.

     * @param  bool $baseOnly
     * @return string
     */
    public function getNamespace(bool $baseOnly = false): string
    {
        return Objects::getNamespace($this, $baseOnly);
    }

    /**
     * Get parent.
     *
     * @return string|null
     */
    public function getParent(): string|null
    {
        return Objects::getParent($this);
    }

    /**
     * Get parents.
     *
     * @return array|null
     */
    public function getParents(): array|null
    {
        return Objects::getParents($this);
    }

    /**
     * Get interfaces.
     *
     * @return array|null
     */
    public function getInterfaces(): array|null
    {
        return Objects::getInterfaces($this);
    }

    /**
     * Get traits.
     *
     * @param  bool $all
     * @return array|null
     */
    public function getTraits(bool $all = true): array|null
    {
        return Objects::getTraits($this, $all);
    }

    /**
     * Is type of.
     *
     * @param  string $class
     * @return bool
     */
    public function isTypeOf(string $class): bool
    {
        return (static::class == $class);
    }

    /**
     * Is type of self.
     *
     * @return bool
     */
    public function isTypeOfSelf(): bool
    {
        return (static::class == self::class);
    }

    /**
     * Is instance of.
     *
     * @param  object|string $object
     * @return bool
     */
    public function isInstanceOf(object|string $object): bool
    {
        return ($this instanceof $object);
    }

    /**
     * Is equal of.
     *
     * @param  object $object
     * @param  bool   $strict
     * @return bool
     */
    public function isEqualOf(object $object, bool $strict = true): bool
    {
        return ($strict ? $this === $object : $this == $object);
    }

    /**
     * Is equal hash of.
     *
     * @param  object $object
     * @return bool
     */
    public function isEqualHashOf(object $object): bool
    {
        return Objects::getSerializedHash($this) == Objects::getSerializedHash($object);
    }
}
