<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Attribute Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\AttributeTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait AttributeTrait
{
    /**
     * Attribute.
     * @var array<string, any>
     */
    protected array $attributes = [];

    /**
     * Attribute (set/get).
     * @param  string   $name
     * @param  any|null $value
     * @return any
     */
    public final function attribute(string $name, $value = null)
    {
        return func_num_args() == 1 ? $this->getAttribute($name)
                                    : $this->setAttribute($name, $value);
    }

    /**
     * Has attribute.
     * @param  string $name
     * @return bool
     */
    public final function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Has attribute value.
     * @param  string $name
     * @return bool
     */
    public final function hasAttributeValue(string $name): bool
    {
        return array_key_exists($name, $this->attributes) && $this->attributes[$name] !== null;
    }

    /**
     * Set attribute.
     * @param  string $name
     * @param  any    $value
     * @return self
     */
    public final function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Get attribute.
     * @param  string   $name
     * @param  any|null $default
     * @return any|null
     */
    public final function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * Remove attribute.
     * @param  string $name
     * @return self
     */
    public final function removeAttribute(string $name): self
    {
        unset($this->attributes[$name]);

        return $this;
    }

    /**
     * Set attributes.
     * @param  array<string, any>|null $attributes
     * @param  array<string, any>|null $defaults
     * @param  bool                    $recursive
     * @return self
     */
    public final function setAttributes(?array $attributes, ?array $defaults = null, bool $recursive = true): self
    {
        $attributes ??= [];

        if ($defaults != null) {
            $attributes = $recursive ? array_replace_recursive($defaults, $attributes)
                : array_replace($defaults, $attributes);
        }

        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Get attributes.
     * @return array<string>|null $names
     * @return array<any>
     */
    public final function getAttributes(array $names = null): array
    {
        // All wanted.
        if ($names === null) {
            return $this->attributes;
        }

        $values = [];
        foreach ($names as $name) {
            $values[] = $this->getAttribute($name);
        }
        return $values;
    }

    /**
     * Remove attributes.
     * @param  array<string> $names
     * @return self
     */
    public final function removeAttributes(array $names): self
    {
        foreach ($names as $name) {
            $this->removeAttribute($name);
        }

        return $this;
    }
}
