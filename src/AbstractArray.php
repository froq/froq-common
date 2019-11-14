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

namespace froq\core;

use froq\core\AbstractObject;
use froq\core\interfaces\{Arrayable, Objectable, Yieldable};
use froq\core\throwables\InvalidArgumentException;
use Countable, IteratorAggregate, ArrayIterator, Traversable, stdClass;

/**
 * Abstract Array.
 *
 * Represents an abstract but extended array object that provides couple of utility methods which
 * access, modify or iterate $data items.
 *
 * @package froq\core
 * @object  froq\core\AbstractArray
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
abstract class AbstractArray extends AbstractObject implements Arrayable, Objectable, Yieldable,
    Countable, IteratorAggregate
{
    /**
     * Data.
     * @var array<int|string, any>
     */
    protected array $data = [];

    /**
     * Constructor.
     * @param  array|object|iterable|null $data
     * @throws froq\core\throwables\InvalidArgumentException
     */
    public function __construct($data = null)
    {
        $data = $data ?? [];

        if (is_array($data)) {
            $this->data = $data;
        } elseif ($data instanceof stdClass) {
            $this->data = (array) $data;
        } elseif ($data instanceof Traversable) {
            $this->data = iterator_to_array($data);
        } else {
            throw new InvalidArgumentException('Invalid argument, valids are '.
                'array|object|iterable|null');
        }
    }

    /**
     * Clone.
     * @return static
     */
    public function __clone()
    {
        return $this->copy();
    }

    /**
     * Serialize (with PHP/7.4).
     * @return array
     */
    public function __serialize()
    {
        return $this->getData();
    }

    /**
     * Unserialize (with PHP/7.4).
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
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

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
     * Copy.
     * @return object
     */
    public function copy(): object
    {
        return new static($this->data);
    }

    /**
     * Merge.
     * @param  self $collection
     * @return self
     */
    public function merge(self $collection): self
    {
        foreach ($collection as $key => $value) {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * Empty.
     * @return void
     */
    public function empty(): void
    {
        $this->data = [];
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
     * Map.
     * @param  callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->data));
    }

    /**
     * Filter.
     * @param  callable $callback
     * @return static
     */
    public function filter(callable $callback)
    {
        return new static(array_filter($this->data, $callback));
    }

    /**
     * Reduce.
     * @param  any|null $initialValue
     * @param  callable $callback
     * @return any
     */
    public function reduce($initialValue = null, callable $callback)
    {
        return array_reduce($this->data, $callback, $initialValue);
    }

    /**
     * @inheritDoc froq\core\interfaces\Yieldable
     */
    public function yield(): iterable
    {
        foreach ($this->data as $key => $value) {
            yield $key => $value;
        }
    }

    /**
     * @inheritDoc froq\core\interfaces\Arrayable
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc froq\core\interfaces\Objectable
     */
    public function toObject(): object
    {
        return $this->data;
    }

    /**
     * @inheritDoc Countable
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc IteratorAggregate
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->data);
    }
}
