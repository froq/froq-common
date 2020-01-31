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

namespace froq\common\traits;

/**
 * Option Trait.
 * @package froq\common\traits
 * @object  froq\common\traits\OptionTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait OptionTrait
{
    /**
     * Options.
     * @var array<string, any>
     */
    protected array $options = [];

    /**
     * Has option.
     * @param  string $key
     * @return bool
     */
    public final function hasOption(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * Has option value.
     * @param  string $key
     * @return bool
     */
    public final function hasOptionValue(string $key): bool
    {
        return array_key_exists($key, $this->options) && $this->options[$key] !== null;
    }

    /**
     * Set option.
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
     * Get option.
     * @param  string   $key
     * @param  any|null $valueDefault
     * @return any|null
     */
    public final function getOption(string $key, $valueDefault = null)
    {
        return $this->options[$key] ?? $valueDefault;
    }

    /**
     * Remove option.
     * @param  string $key
     * @return self
     */
    public final function removeOption(string $key): self
    {
        unset($this->options[$key]);

        return $this;
    }

    /**
     * Set options.
     * @param  array<string, any> $options
     * @return self
     */
    public final function setOptions(array $options): self
    {
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }

        return $this;
    }

    /**
     * Get options.
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
            $values[] = $this->options[$key] ?? null;
        }
        return $values;
    }

    /**
     * Remove options.
     * @param  array<string> $keys
     * @return self
     */
    public final function removeOptions(string $keys): self
    {
        foreach ($keys as $key) {
            $this->removeOption($key);
        }

        return $this;
    }
}
