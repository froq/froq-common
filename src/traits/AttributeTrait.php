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

namespace froq\core\traits;

/**
 * Attribute Trait.
 * @package froq\core\traits
 * @object  froq\core\traits\AttributeTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait AttributeTrait
{
    /**
     * Attribute.
     * @var array<string, any>
     */
    protected $attributes = [];

    /**
     * Has attribute.
     * @param  string $name
     * @return bool
     */
    public final function hasAttribute(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Set attribute.
     * @param  string $name
     * @param  any    $value
     * @return void
     */
    public final function setAttribute(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Get attribute.
     * @param  string $name
     * @return any|null
     */
    public final function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Remove attribute.
     * @param  string $name
     * @return void
     */
    public final function removeAttribute(string $name): void
    {
        unset($this->attributes[$name]);
    }

    /**
     * Set attributes.
     * @param  array<string, any> $attributes
     * @return void
     */
    public final function setAttributes(array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Get attributes.
     * @return array<string>|null $names
     * @return array<any>
     */
    public final function getAttributes(array $names = null): array
    {
        if ($names == null) {
            return $this->attributes;
        }

        $values = [];
        foreach ($names as $name) {
            $values[] = $this->attributes[$name] ?? null;
        }
        return $values;
    }

    /**
     * Remove attributes.
     * @param  array<string> $names
     * @return bool
     */
    public final function removeAttributes(array $names): void
    {
        foreach ($names as $name) {
            $this->removeAttribute($name);
        }
    }
}
