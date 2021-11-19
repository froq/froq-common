<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\interface\{Arrayable, Objectable, Listable, Jsonable, Yieldable};
use froq\common\exception\InvalidKeyException;
use froq\collection\iterator\{ArrayIterator, ReverseArrayIterator};
use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, AggregateTrait, ReadOnlyTrait};
use froq\util\Arrays;
use Traversable, Countable, JsonSerializable, IteratorAggregate, ReflectionMethod;

/**
 * X-Array.
 *
 * Represents an abstract but extended array object that provides couple of utility methods which
 * access, modify or iterate `$data` items.
 *
 * @package froq\common\object
 * @object  froq\common\object\XArray
 * @author  Kerem Güneş
 * @since   4.0
 */
abstract class XArray implements Arrayable, Objectable, Listable, Jsonable, Yieldable,
    Countable, JsonSerializable, IteratorAggregate
{
    /** @see froq\collection\trait\SortTrait */
    /** @see froq\collection\trait\EachTrait */
    /** @see froq\collection\trait\FilterTrait */
    /** @see froq\collection\trait\MapTrait */
    /** @see froq\collection\trait\ReduceTrait */
    /** @see froq\collection\trait\AggregateTrait */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, AggregateTrait;

    /** @see froq\collection\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /** @var array<int|string, any> */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable|null $data
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

        // Get key type(s) from child, or self for this method.
        static $getTypes; $getTypes ??= fn() =>
            grep((new ReflectionMethod(static::class, 'setData'))->getDocComment() ?: '',
                '~@param +array<([^,]+).*> +\$data~') ?? 'int|string'
        ;

        $types = $getTypes();

        // Validate keys.
        foreach (array_keys($data) as $key) {
            if ($key === '') throw new InvalidKeyException(
                'Empty keys not allowed for %s object', static::class
            );

            switch ($types) {
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
     * @param  static (self) $array
     * @return static
     */
    public function copyTo(self $array): static
    {
        $array->setData($this->data);

        return $array;
    }

    /**
     * Empty data stack.
     *
     * @return self
     * @since  5.0
     */
    public function empty(): self
    {
        $this->readOnlyCheck();

        $this->data = [];

        return $this;
    }

    /**
     * Check whether data stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Get keys of data stack.
     *
     * @return array<int|string>
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Get values of data stack.
     *
     * @return array<any>
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * Get entries of data stack.
     *
     * @return array<array>
     * @since  5.0
     */
    public function entries(): array
    {
        $ret = [];

        foreach ($this->data as $key => $value) {
            $ret[] = [$key, $value];
        }

        return $ret;
    }

    /**
     * Check whether data stack contains given value.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     * @since  5.0
     */
    public function contains($value, bool $strict = false): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Check whether data stack contains given key.
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
     * Check whether data stack is a list.
     *
     * @return bool
     * @since  5.4
     */
    public function isList(): bool
    {
        return is_list($this->data);
    }

    /**
     * @inheritDoc froq\common\interface\Listable
     */
    public function toList(): array
    {
        return array_values($this->data);
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc froq\common\interface\Objectable
     */
    public function toObject(): object
    {
        return (object) $this->data;
    }

    /**
     * @inheritDoc froq\common\interface\Jsonable
     */
    public function toJson(int $flags = 0): string
    {
        return (string) json_encode($this->data, $flags);
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
     * @note Return is permissive.
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @since 5.4
     * @note Return is permissive.
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

    /** Aliases. */
    public function array() { return $this->toArray(); }
    public function object() { return $this->toObject(); }
    public function json(...$args) { return $this->toJson(...$args); }
}
