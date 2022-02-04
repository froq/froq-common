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
use froq\common\{Exception, exception\InvalidKeyException};

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
    use DataCountTrait, DataEmptyTrait, DataToArrayTrait, DataToObjectTrait, DataToListTrait, DataToJsonTrait,
        DataIteratorTrait;

    /** @magic */
    public function __serialize(): array
    {
        return $this->getData();
    }

    /** @magic */
    public function __unserialize(array $data): void
    {
        $this->setData($data);
    }

    /** @magic */
    public function __debugInfo(): array
    {
        return $this->getData();
    }

    /**
     * Set data.
     *
     * @param  array<int|string, any> $data
     * @param  bool                   $reset
     * @return self
     * @throws froq\common\exception\InvalidKeyException
     */
    public function setData(array $data, bool $reset = true): self
    {
        // For key checks.
        $checkedKeys = false;

        $keyCheckEmpty = static function (int|string $key, int $offset) {
            if ($key === '') throw new InvalidKeyException(
                'Empty keys not allowed for %s object [offset: %s]',
                [static::class, $offset]
            );
        };

        $class = new \XObject($this);

        // Call child's keyCheck() if exists.
        if ($data && $class->existsMethod('keyCheck')) {
            $i = 0;
            foreach ($data as $key => $_) {
                $keyCheckEmpty($key, $i++);

                $this->keyCheck($key, true);
            }

            $checkedKeys = true;
        }

        // Call child's set() if exists.
        if ($data && $class->existsMethod('set')) {
            $i = 0;
            foreach ($data as $key => $value) {
                $keyCheckEmpty($key, $i++);

                $this->set($key, $value);
            }

            return $this;
        }

        // Proceed key checks.
        if ($data && !$checkedKeys) {
            // Get key type from child's setData() or this method.
            $type = grep(
                $class->reflect()->getMethod('setData')->getDocComment() ?: '',
                '~@param +array<([^,]+).*> +\$data~'
            ) ?: 'int|string';

            // Validate keys.
            foreach (array_keys($data) as $i => $key) {
                $keyCheckEmpty($key, $i);

                match ($type) {
                    'int' => is_int($key) || throw new InvalidKeyException(
                        'Only int keys allowed for object %s, %s given [offset: %s]',
                        [static::class, get_type($key), $i]
                    ),
                    'string' => is_string($key) || throw new InvalidKeyException(
                        'Only string keys allowed for object %s, %s given [offset: %s]',
                        [static::class, get_type($key), $i]
                    ),
                    'int|string' => is_int($key) || is_string($key) || throw new InvalidKeyException(
                        'Only int|string keys allowed for object %s, %s given [offset: %s]',
                        [static::class, get_type($key), $i]
                    ),
                    default => throw new Exception(
                        'Invalid key type `%s` [valids: int,string,int|string]',
                        $type
                    )
                };
            }
        }

        if ($reset) {
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
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set data default.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @param  bool       $isset
     * @return self
     * @since  5.0
     */
    public function setDataDefault(int|string $key, mixed $value, bool $isset = true): self
    {
        $defaults = [$key => $value];

        return $this->setDataDefaults($defaults, $isset);
    }

    /**
     * Set data defaults.
     *
     * @param  array $defaults
     * @param  bool  $isset
     * @return self
     * @since  4.1, 5.0
     */
    public function setDataDefaults(array $defaults, bool $isset = true): self
    {
        foreach ($defaults as $key => $value) {
            $ok = $isset ? isset($this->data[$key])
                         : array_key_exists($key, $this->data);

            // Set default if not ok.
            $ok || $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Reset data (without checks in setData()).
     *
     * @param  array $data
     * @return self
     * @since  5.0
     */
    public function resetData(array $data): self
    {
        $this->data = $data;

        return $this;
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
        $that->setData($this->getData());

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
        $this->setData($that->getData());

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
     * Check whether data array contains given value.
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
     * Check whether data array contains given key.
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
