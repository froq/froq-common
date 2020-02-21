<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\common\objects;

use froq\common\interfaces\{Cloneable, Stringable};
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
abstract class AbstractObject implements Cloneable, Stringable
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
    public final function isInstanceOf($class): bool
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
    public function toClone(): object
    {
        return clone $this;
    }

    /**
     * @inheritDoc froq\common\interfaces\Stringable
     */
    public function toString(): string
    {
        $vars = get_object_vars($this);

        return sprintf('object(%s)#%s (%s) { %s }', $this->getName(), spl_object_id($this),
            count($vars), join(', ', array_keys($vars)));
    }
}
