<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\interface\{Arrayable, Objectable, Listable, Jsonable, Yieldable};
use froq\common\exception\{InvalidKeyException, InvalidArgumentException, RuntimeException};
use froq\util\Arrays;
use Traversable, Countable, JsonSerializable, IteratorAggregate, ArrayIterator;

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
     */
    public function setData(array $data, bool $reset = true): self
    {
        // Not exists for all children.
        method_exists($this, 'readOnlyCheck') && $this->readOnlyCheck();

        // Get key type(s) from child, or self for this method.
        static $getTypes; $getTypes ??= fn() =>
            grep((new \ReflectionMethod(static::class, 'setData'))->getDocComment(),
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
     * Reset data, without type/read-only checks like in setData().
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
        // Not exists for all children.
        method_exists($this, 'readOnlyCheck') && $this->readOnlyCheck();

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
     * Run given function on each item of data stack.
     *
     * @param  callable $func
     * @return self
     */
    public function each(callable $func): self
    {
        foreach ($this->data as $key => &$value) {
            $func($value, $key);
        }

        // Drop ref.
        unset($value);

        return $this;
    }

    /**
     * Filter.
     *
     * @param  callable|null $func
     * @param  bool          $keepKeys
     * @return self
     */
    public function filter(callable $func = null, bool $keepKeys = true): self
    {
        $data = Arrays::filter($this->data, $func, $keepKeys);

        return $this->setData($data);
    }

    /**
     * Map.
     *
     * @param  callable $func
     * @param  bool     $keepKeys
     * @return self
     */
    public function map(callable $func, bool $keepKeys = true): self
    {
        $data = Arrays::map($this->data, $func, $keepKeys);

        return $this->setData($data);
    }

    /**
     * Map all data items as given type.
     *
     * @param  string $type
     * @return self
     * @since  5.0
     */
    public function mapAs(string $type): self
    {
        // Check given type for proper error message, not like settype()'s like.
        preg_match($pattern = '~^(int|float|string|bool|array|object|null)$~', $type)
            || throw new InvalidArgumentException('Invalid type `%s`, valid type pattern: %s', [$type, $pattern]);

        return $this->map(function ($item) use ($type) {
            settype($item, $type);

            return $item;
        });
    }

    /**
     * Map all data items to given class.
     *
     * @notice This method must be used on list-data containing objects, not single-dimensions.
     * @param  string $class
     * @return self
     * @since  5.0
     */
    public function mapTo(string $class): self
    {
        class_exists($class) || throw new RuntimeException('Class `%s` not exists', [$class]);

        $object = new $class();

        return $this->map(function ($item) use ($object) {
            $clone = clone $object;

            foreach ($item as $key => $value) {
                $clone->{$key} = $value;
            }

            return $clone;
        });
    }

    /**
     * Reduce.
     *
     * @param  any      $carry
     * @param  callable $func
     * @return any
     */
    public function reduce($carry, callable $func)
    {
        return Arrays::reduce($this->data, $carry, $func);
    }

    /**
     * Aggregate.
     *
     * @param  callable   $func
     * @param  array|null $carry
     * @return array
     * @since  4.5
     */
    public function aggregate(callable $func, array $carry = null): array
    {
        return Arrays::aggregate($this->data, $func, $carry);
    }

    /** Aliases. */
    public function array()  { return $this->toArray(); }
    public function object() { return $this->toObject(); }

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
     * Create an instance with given data.
     *
     * @param  iterable $data
     * @return static
     */
    public static function from(iterable $data): static
    {
        return new static($data);
    }
}
