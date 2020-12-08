<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\objects;

use froq\common\interfaces\{Arrayable, Objectable, Jsonable, Yieldable};
use froq\util\Arrays;
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
        // Not exists for all children.
        method_exists($this, 'readOnlyCheck') && $this->readOnlyCheck();

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
     * Empty.
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
     * Filter.
     * @param  callable|null $func
     * @param  bool          $keepKeys
     * @return self (static)
     */
    public function filter(callable $func = null, bool $keepKeys = true): self
    {
        $data = Arrays::filter($this->data, $func, $keepKeys);

        return $this->setData($data);
    }

    /**
     * Map.
     * @param  callable $func
     * @param  bool     $keepKeys
     * @return self (static)
     */
    public function map(callable $func, bool $keepKeys = true): self
    {
        $data = Arrays::map($this->data, $func, $keepKeys);

        return $this->setData($data);
    }

    /**
     * Reduce.
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
     * @param  callable   $func
     * @param  array|null $carry
     * @return array
     * @since  4.5
     */
    public function aggregate(callable $func, array $carry = null): array
    {
        return Arrays::aggregate($this->data, $func, $carry);
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
