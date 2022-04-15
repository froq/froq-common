<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
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
     * Get data fields by given keys or all data array.
     *
     * @param  array<string|int>|string|int $keys
     * @param  bool|null                    $combine
     * @return mixed
     */
    public function data(array|string|int $keys = null, bool $combine = null): mixed
    {
        if ($keys === null) {
            return $this->data;
        }

        $combine ??= is_array($keys);

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
