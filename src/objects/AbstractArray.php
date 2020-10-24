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

use froq\common\interfaces\{Arrayable, Objectable, Jsonable, Yieldable};
use Traversable, Countable, JsonSerializable, IteratorAggregate, ArrayIterator;

/**
 * Abstract Array.
 *
 * Represents an abstract but extended array object that provides couple of utility methods which
 * access, modify or iterate `$data` items.
 *
 * @package froq\common\objects
 * @object  froq\common\objects\AbstractArray
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
abstract class AbstractArray implements Arrayable, Objectable, Jsonable, Yieldable,
    Countable, JsonSerializable, IteratorAggregate
{
    /**
     * Data.
     * @var array<int|string, any>
     */
    protected array $data = [];

    /**
     * Constructor.
     * @param  iterable|null $data
     * @throws froq\common\exceptions\InvalidArgumentException
     */
    public function __construct(iterable $data = null)
    {
        if ($data != null) {
            if ($data instanceof Traversable) {
                $data = iterator_to_array($data);
            }
            $this->setData($data);
        }
    }

    /**
     * Clone.
     * @return self (static)
     */
    public function __clone()
    {
        return $this->copy();
    }

    /**
     * Serialize.
     * @return array
     */
    public function __serialize()
    {
        return $this->getData();
    }

    /**
     * Unserialize.
     * @param  array $data
     * @return void
     */
    public function __unserialize($data)
    {
        $this->setData($data);
    }

    /**
     * Set data.
     * @param  array $data
     * @param  bool  $override
     * @return self (static)
     */
    public function setData(array $data, bool $override = true): self
    {
        if ($override) {
            $this->data = $data;
        } else {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Get data.
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set data default.
     * @param  array $default
     * @param  bool  $nullCheck
     * @return self (static)
     * @since 4.1
     */
    public function setDataDefault(array $default, bool $nullCheck = true): self
    {
        foreach ($default as $key => $value) {
            $ok = $nullCheck ? isset($this->data[$key])
                             : array_key_exists($key, $this->data);
            // Set default if not ok.
            $ok || $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Copy.
     * @return self (static)
     */
    public function copy(): self
    {
        return new static($this->data);
    }

    /**
     * Copy to.
     * @param  self (static) $array
     * @return self (static)
     */
    public function copyTo(self $array): self
    {
        $array->setData($this->data);

        return $array;
    }

    /**
     * Is empty.
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Keys.
     * @return array<int|string>
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Values.
     * @return array<any>
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * Each.
     * @param  callable $func
     * @return self (static)
     */
    public function each(callable $func): self
    {
        foreach ($this->data as $key => $value) {
            $func($value, $key);
        }

        return $this;
    }

    /**
     * Apply.
     * @param  callable $func
     * @return self (static)
     * @since  4.2
     */
    public function apply(callable $func): self
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            // Argument $value must be passed with ref (eg: (&$value, ...) ...),
            // so "return ..." not used, but just modifing value.
            $func($value, $key, $this->data);

            $data[$key] = $value;
        }

        return $this->setData($data);
    }

    /**
     * Filter.
     * @param  callable $func
     * @param  bool     $keepKeys
     * @return self (static)
     */
    public function filter(callable $func, bool $keepKeys = true): self
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            $func($value, $key, $this->data) && (
                $keepKeys ? $data[$key] = $value : $data[] = $value
            );
        }

        return $this->setData($data);
    }

    /**
     * Map.
     * @param  callable $func
     * @return self (static)
     */
    public function map(callable $func): self
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            $data[$key] = $func($value, $key, $this->data);
        }

        return $this->setData($data);
    }

    /**
     * Reduce.
     * @param  any      $accumulator
     * @param  callable $func
     * @return any
     */
    public function reduce($accumulator, callable $func)
    {
        foreach ($this->data as $key => $value) {
            $accumulator = $func($accumulator, $value, $key, $this->data);
        }

        return $accumulator;
    }

    /**
     * @inheritDoc froq\common\interfaces\Arrayable
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc froq\common\interfaces\Objectable
     */
    public function toObject(): object
    {
        return (object) $this->data;
    }

    /**
     * @inheritDoc froq\common\interfaces\Jsonable
     */
    public function toJson(int $flags = 0): string
    {
        return json_encode($this->data, $flags);
    }

    /**
     * @inheritDoc froq\common\interfaces\Yieldable
     */
    public function yield(): iterable
    {
        foreach ($this->data as $key => $value) {
            yield $key => $value;
        }
    }

    /**
     * @inheritDoc Countable
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc IteratorAggregate
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * From.
     * @param  iterable $data
     * @return self (static)
     */
    public static function from(iterable $data): self
    {
        return new static($data);
    }
}
