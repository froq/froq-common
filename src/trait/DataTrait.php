<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Trait.
 *
 * Represents a trait entity which carries `$data` property and is able to set/get/empty/count actions.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataTrait
{
    /** @var array $data */
    protected array $data;

    /**
     * Set/get data stack.
     *
     * @param  array $data
     * @return array|self|null
     */
    public function data(array $data = []): array|self|null
    {
        if (func_num_args()) {
            return $this->setData($data);
        }
        return $this->getData();
    }

    /**
     * Get data only by given keys.
     *
     * @param  array|string $keys
     * @return array
     */
    public function dataOnly(array|string $keys): array
    {
        if (is_string($keys)) {
            $keys = explode(' ', $keys);
        }

        return array_select($this->toArray(), $keys, combine: true);
    }

    /**
     * Set data stack.
     *
     * @param  array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data stack.
     *
     * @return array|null
     */
    public function getData(): array|null
    {
        return $this->data ?? null;
    }

    /**
     * Update data stack.
     *
     * @param  array $data
     * @return self
     */
    public function updateData(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Check data empty state.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Empty data stack.
     *
     * @return self
     */
    public function empty(): self
    {
        $this->data = [];

        return $this;
    }

    /**
     * Get count/size of data stack.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->toArray());
    }

    /**
     * Get data stack or an empty array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data ?? [];
    }

    /** Shorties. */
    public function array()  { return $this->toArray(); }
    public function object() { return (object) $this->toArray(); }
}
