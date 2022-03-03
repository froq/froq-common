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
 * A trait, provides access/modify methods for the classes defining `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataTrait
{
    /**
     * Set/get data array.
     *
     * @param  array $data
     * @return array|self
     */
    public function data(array $data = []): array|self
    {
        return func_num_args() ? $this->setData($data) : $this->getData();
    }

    /**
     * Get data fields by given keys.
     *
     * @param  array|string $keys
     * @param  bool         $combine
     * @return array
     */
    public function dataOnly(array|string $keys, bool $combine = true): array
    {
        // Comma-separated list.
        if (is_string($keys)) {
            $keys = split('\s*,\s*', $keys);
        }

        return array_select($this->data, $keys, combine: $combine);
    }

    /**
     * Set data array.
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
     * Get data array.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Update data array.
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
}
