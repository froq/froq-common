<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\common\trait\{DataCountTrait, DataEmptyTrait, DataToArrayTrait, DataToObjectTrait, DataToListTrait,
    DataToJsonTrait, DataIteratorTrait};
use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, ApplyTrait, AggregateTrait,
    FindTrait, MinMaxTrait, FirstLastTrait};
use froq\collection\iterator\{ArrayIterator, ReverseArrayIterator};

/**
 * Array Trait.
 *
 * A trait for array-like classes these hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ArrayTrait
 * @author  Kerem Güneş
 * @since   4.0, 6.0
 */
trait ArrayTrait
{
    /**
     * @see froq\collection\trait\SortTrait
     * @see froq\collection\trait\EachTrait
     * @see froq\collection\trait\FilterTrait
     * @see froq\collection\trait\MapTrait
     * @see froq\collection\trait\ReduceTrait
     * @see froq\collection\trait\ApplyTrait
     * @see froq\collection\trait\AggregateTrait
     * @see froq\collection\trait\FindTrait
     * @see froq\collection\trait\MinMaxTrait
     * @see froq\collection\trait\FirstLastTrait
     */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, ApplyTrait, AggregateTrait,
        FindTrait, MinMaxTrait, FirstLastTrait;

    /**
     * @see froq\common\trait\DataCountTrait
     * @see froq\common\trait\DataEmptyTrait
     * @see froq\common\trait\DataToArrayTrait
     * @see froq\common\trait\DataToObjectTrait
     * @see froq\common\trait\DataToListTrait
     * @see froq\common\trait\DataToJsonTrait
     * @see froq\common\trait\DataIteratorTrait
     */
    use DataCountTrait, DataEmptyTrait, DataToArrayTrait, DataToObjectTrait, DataToListTrait,
        DataToJsonTrait, DataIteratorTrait;

    /** @magic */
    public function __serialize(): array
    {
        return $this->data;
    }

    /** @magic */
    public function __unserialize(array $data): void
    {
        $this->data = $data;
    }

    /** @magic */
    public function __debugInfo(): array
    {
        return $this->data;
    }

    /**
     * Copy.
     *
     * @return static
     */
    public function copy(): static
    {
        return new static($this->data);
    }

    /**
     * Copy to.
     *
     * @param  self (static) $that
     * @return static
     */
    public function copyTo(self $that): static
    {
        $that->data = $this->data;

        return $that;
    }

    /**
     * Copy from.
     *
     * @param  self (static) $that
     * @return static
     */
    public function copyFrom(self $that): static
    {
        $this->data = $that->data;

        return $this;
    }

    /**
     * Get keys of data array.
     *
     * @return array<int|string>
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Get values of data array.
     *
     * @return array<any>
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * Get entries of data array.
     *
     * @return array<array>
     * @since  5.0
     */
    public function entries(): array
    {
        return array_entries($this->data);
    }

    /**
     * Check whether data array contains given value/values.
     *
     * @param  mixed    $value
     * @param  mixed ...$values
     * @return bool
     * @since  5.0
     */
    public function contains(mixed $value, mixed ...$values): bool
    {
        return array_contains($this->data, $value, ...$values);
    }

    /**
     * Check whether data array contains given key/keys.
     *
     * @param  int|string    $key
     * @param  int|string ...$keys
     * @return bool
     * @since  5.0
     */
    public function containsKey(int|string $key, int|string ...$keys): bool
    {
        return array_contains_key($this->data, $key, ...$keys);
    }

    /**
     * @inheritDoc froq\common\interface\Yieldable
     * @since 5.4
     * @note Return is permissive.
     */
    public function yield(bool $reverse = false): iterable
    {
        if (!$reverse) {
            foreach ($this->data as $key => $value) {
                yield $key => $value;
            }
        } else {
            for (end($this->data); ($key = key($this->data)) !== null; prev($this->data)) {
                yield $key => current($this->data);
            }
        }
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc Iteratable
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @inheritDoc IteratableReverse
     */
    public function getReverseIterator(): iterable
    {
        return new ReverseArrayIterator($this->data);
    }

    /**
     * Create an instance with given data.
     *
     * @param  iterable|null $data
     * @return static
     */
    public static function from(iterable|null $data): static
    {
        return new static($data);
    }

    /**
     * Create an instance with given keys (and value optionally).
     *
     * @param  array      $keys
     * @param  mixed|null $value
     * @return static
     * @since  5.14
     */
    public static function fromKeys(array $keys, mixed $value = null): static
    {
        return new static(array_fill_keys($keys, $value));
    }
}
