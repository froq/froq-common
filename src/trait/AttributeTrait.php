<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, defines `$attributes` property as array and able to set/get/check
 * attributes on user object.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\AttributeTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait AttributeTrait
{
    /** Attribute map. */
    protected array $attributes = [];

    /**
     * Get/get an attribute.
     *
     * @param  string     $name
     * @param  mixed|null $value
     * @return mixed|null or self
     */
    public final function attribute(string $name, mixed $value = null): mixed
    {
        return func_num_args() === 1 ? $this->getAttribute($name) : $this->setAttribute($name, $value);
    }

    /**
     * Check whether an attribute exists with given name.
     *
     * @param  string $name
     * @return bool
     */
    public final function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Set an attribute with given name and value.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return self
     */
    public final function setAttribute(string $name, mixed $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Get an attribute with given name.
     *
     * @param  string     $name
     * @param  mixed|null $default
     * @return mixed|null
     */
    public final function getAttribute(string $name, mixed $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * Remove an attribute by given name.
     *
     * @param  string $name
     * @return self
     */
    public final function removeAttribute(string $name): self
    {
        unset($this->attributes[$name]);

        return $this;
    }

    /**
     * Set attributes with optional defaults.
     *
     * @param  array<string, mixed>|null $attributes
     * @param  array<string, mixed>|null $defaults
     * @param  bool                      $recursive
     * @return self
     */
    public final function setAttributes(?array $attributes, ?array $defaults = null, bool $recursive = true): self
    {
        $attributes ??= [];

        if ($defaults) {
            $attributes = $recursive ? array_replace_recursive($defaults, $attributes)
                : array_replace($defaults, $attributes);
        }

        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Get attributes by given names.
     *
     * @param  array<string>|null $names
     * @param  bool               $combine
     * @return array
     */
    public final function getAttributes(array $names = null, bool $combine = false): array
    {
        // All wanted.
        if ($names === null) {
            return $this->attributes;
        }

        $values = [];
        foreach ($names as $name) {
            $values[] = $this->getAttribute($name);
        }

        return $combine ? array_combine($names, $values) : $values;
    }

    /**
     * Remove attributes by given names.
     *
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
