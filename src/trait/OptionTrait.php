<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Option Trait.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\OptionTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait OptionTrait
{
    /** @var array<string, any> */
    protected array $options = [];

    /**
     * Set/get an option.
     *
     * @param  string   $key
     * @param  any|null $value
     * @return any|null|self
     */
    public final function option(string $key, $value = null)
    {
        return func_num_args() == 1 ? $this->getOption($key)
                                    : $this->setOption($key, $value);
    }

    /**
     * Check whether an option exists with given key.
     *
     * @param  string $key
     * @return bool
     */
    public final function hasOption(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * Check whether an option was set with given key.
     *
     * @param  string $key
     * @return bool
     */
    public final function hasOptionValue(string $key): bool
    {
        return isset($this->options[$key]);
    }

    /**
     * Set an option by given key and value.
     *
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * Get an option by given key.
     *
     * @param  string   $key
     * @param  any|null $default
     * @return any|null
     */
    public final function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Remove an option by given key.
     *
     * @param  string $key
     * @return self
     */
    public final function removeOption(string $key): self
    {
        unset($this->options[$key]);

        return $this;
    }

    /**
     * Set options with optional defaults.
     *
     * @param  array<string, any>|null $options
     * @param  array<string, any>|null $defaults
     * @param  bool                    $recursive
     * @return self
     */
    public final function setOptions(?array $options, ?array $defaults = null, bool $recursive = true): self
    {
        $options ??= [];

        if ($defaults != null) {
            $options = $recursive ? array_replace_recursive($defaults, $options)
                : array_replace($defaults, $options);
        }

        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }

        return $this;
    }

    /**
     * Get options by given keys.
     *
     * @return array<string>|null $keys
     * @return array<any>
     */
    public final function getOptions(array $keys = null): array
    {
        // All wanted.
        if ($keys === null) {
            return $this->options;
        }

        $values = [];

        foreach ($keys as $key) {
            $values[] = $this->getOption($key);
        }

        return $values;
    }

    /**
     * Remove options by given keys.
     *
     * @param  array<string> $keys
     * @return self
     */
    public final function removeOptions(array $keys): self
    {
        foreach ($keys as $key) {
            $this->removeOption($key);
        }

        return $this;
    }
}
