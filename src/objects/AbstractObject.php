<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\objects;

use froq\common\interfaces\{Cloneable, Arrayable, Stringable};
use froq\util\Objects;
use ReflectionObject;

/**
 * Abstract Object.
 *
 * Represents an abstract but extended object that provides couple of utility methods which access
 * and check object's attributes.
 *
 * @package froq\common\objects
 * @object  froq\common\objects\AbstractObject
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
abstract class AbstractObject implements Cloneable, Arrayable, Stringable
{
    /**
     * Get name.
     * @return string
     */
    public final function getName(): string
    {
        return Objects::getName($this);
    }

    /**
     * Get short name.
     * @return string
     */
    public final function getShortName(): string
    {
        return Objects::getShortName($this);
    }

    /**
     * Get namespace.
     * @param  bool $baseOnly
     * @return string
     */
    public final function getNamespace(bool $baseOnly = false): string
    {
        return Objects::getNamespace($this, $baseOnly);
    }

    /**
     * Get reflection.
     * @return ReflectionObject
     */
    public final function getReflection(): ReflectionObject
    {
        return new ReflectionObject($this);
    }

    /**
     * Is type of.
     * @param  string $class
     * @return bool
     */
    public final function isTypeOf(string $class): bool
    {
        return (static::class == $class);
    }

    /**
     * Is type of self.
     * @return bool
     */
    public final function isTypeOfSelf(): bool
    {
        return (static::class == self::class);
    }

    /**
     * Is instance of.
     * @param  string|object $class
     * @return bool
     */
    public final function isInstanceOf(string|object $class): bool
    {
        return ($this instanceof $class);
    }

    /**
     * Is equal to.
     * @param  object $object
     * @param  bool   $strict
     * @return bool
     */
    public final function isEqualTo(object $object, bool $strict = false): bool
    {
        return !$strict ? ($this == $object) : ($this === $object);
    }

    /**
     * @inheritDoc froq\common\interfaces\Cloneable
     */
    public function toClone(): static
    {
        return clone $this;
    }

    /**
     * @inheritDoc froq\common\interfaces\Arrayable
     */
    public function toArray(bool $all = false): array
    {
        return get_class_properties($this, true, !$all);
    }

    /**
     * @inheritDoc froq\common\interfaces\Stringable
     */
    public function toString(): string
    {
        $vars = $this->toArray(true);

        return sprintf('object(%s)#%s (%s) { %s }', $this->getName(), spl_object_id($this),
            count($vars), join(', ', array_keys($vars)));
    }
}
