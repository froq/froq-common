<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\exception\InvalidKeyException;
use froq\common\interface\{Arrayable, Objectable, Listable, Jsonable, Yieldable, Iteratable, IteratableReverse};
use froq\common\trait\{DataCountTrait, DataEmptyTrait, DataListTrait, DataToArrayTrait, DataToObjectTrait,
    DataToJsonTrait, DataIteratorTrait, ReadOnlyTrait};
use froq\collection\iterator\{ArrayIterator, ReverseArrayIterator};
use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, ApplyTrait, AggregateTrait};
use froq\util\Arrays;
use Iterator, Countable, JsonSerializable, Traversable, ReflectionMethod;

/**
 * X-Array.
 *
 * Represents an abstract but very extended array object that provides couple of utility methods
 * do access, modify or iterate stuff.
 *
 * @package froq\common\object
 * @object  froq\common\object\XArray
 * @author  Kerem Güneş
 * @since   4.0
 */
abstract class XArray implements Arrayable, Objectable, Listable, Jsonable, Yieldable, Iteratable, IteratableReverse,
    Iterator, Countable, JsonSerializable
{
    /**
     * @see froq\collection\trait\SortTrait
     * @see froq\collection\trait\EachTrait
     * @see froq\collection\trait\FilterTrait
     * @see froq\collection\trait\MapTrait
     * @see froq\collection\trait\ReduceTrait
     * @see froq\collection\trait\ApplyTrait
     * @see froq\collection\trait\AggregateTrait
     */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, ApplyTrait, AggregateTrait;

    /**
     * @see froq\common\trait\DataCountTrait
     * @see froq\common\trait\DataEmptyTrait
     * @see froq\common\trait\DataListTrait
     * @see froq\common\trait\DataToArrayTrait
     * @see froq\common\trait\DataToObjectTrait
     * @see froq\common\trait\DataToJsonTrait
     * @see froq\common\trait\DataIteratorTrait
     */
    use DataCountTrait, DataEmptyTrait, DataListTrait, DataToArrayTrait, DataToObjectTrait, DataToJsonTrait,
        DataIteratorTrait;

    /** @see froq\common\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /** @var array<int|string, any> */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable|null $data
     * @param bool|null     $readOnly
     */
    public function __construct(iterable $data = null, bool $readOnly = null)
    {
        if ($data != null) {
            if ($data instanceof Traversable) {
                $data = iterator_to_array($data);
            }

            $this->setData($data);
        }

        $this->readOnly($readOnly);
    }

    /**
     * Magic - clone.
     *
     * @return static
     */
    public function __clone()
    {
        return $this->copy();
    }

    /**
     * Magic - serialize.
     *
     * @return array
     */
    public function __serialize()
    {
        return $this->getData();
    }

    /**
     * Magic - unserialize.
     *
     * @param  array $data
     * @return void
     */
    public function __unserialize($data)
    {
        $this->setData($data);
    }

    /**
     * Set data.
     *
     * @param  array<int|string, any> $data
     * @param  bool                   $reset
     * @return self
     * @throws froq\common\exception\InvalidKeyException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function setData(array $data, bool $reset = true): self
    {
        $this->readOnlyCheck();

        // Get key type from child's getData() or this method.
        $type = grep((new ReflectionMethod(static::class, 'setData'))->getDocComment() ?: '',
                     '~@param +array<([^,]+).*> +\$data~'
                ) ?? 'int|string';

        // Validate keys.
        foreach (array_keys($data) as $key) {
            if ($key === '') throw new InvalidKeyException(
                'Empty keys not allowed for %s object', static::class
            );

            switch ($type) {
                case 'int|string':
                    is_int($key) || is_string($key) || throw new InvalidKeyException(
                        'Only int|string keys allowed for object %s, %s given',
                        [static::class, get_type($key)]
                    );
                    break;
                case 'int':
                    is_int($key) || throw new InvalidKeyException(
                        'Only int keys allowed for object %s, %s given',
                        [static::class, get_type($key)]
                    );
                    break;
                case 'string':
                    is_string($key) || throw new InvalidKeyException(
                        'Only string keys allowed for object %s, %s given',
                        [static::class, get_type($key)]
                    );
                    break;
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
     * @param  any        $value
     * @param  bool       $nullCheck
     * @return self
     * @since  5.0 Replaced with setDataDefaults().
     */
    public function setDataDefault(int|string $key, $value, bool $nullCheck = true): self
    {
        $defaults = [$key => $value];

        return self::setDataDefaults($defaults, $nullCheck);
    }

    /**
     * Set data defaults.
     *
     * @param  array $defaults
     * @param  bool  $nullCheck
     * @return self
     * @since  4.1, 5.0
     */
    public function setDataDefaults(array $defaults, bool $nullCheck = true): self
    {
        foreach ($defaults as $key => $value) {
            $ok = $nullCheck ? isset($this->data[$key])
                             : array_key_exists($key, $this->data);

            // Set default if not ok.
            $ok || $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Reset data, without type/read-only checks in setData().
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
        $that->setData($this->data);

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
     * Empty data array.
     *
     * @return self
     * @since  5.0
     * @override to DataEmptyTrait.empty()
     */
    public function empty(): self
    {
        $this->readOnlyCheck();

        $this->data = [];

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
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     * @since  5.0
     */
    public function contains($value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Check whether data array contains given key.
     *
     * @param  int|string $key
     * @return bool
     * @since  5.0
     */
    public function containsKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @inheritDoc froq\common\interface\Yieldable
     *
     * @param bool $reverse @since 5.4
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
     * @since 5.4
     */
    public function getReverseIterator(): iterable
    {
        return new ReverseArrayIterator($this->data);
    }

    /**
     * Create an instance with given data.
     *
     * @param  iterable $data
     * @return static
     */
    public static function from(iterable $data): static
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
