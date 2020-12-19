<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
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
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
trait DataTrait
{
    /** @var array $data */
    protected array $data;

    /**
     * Set/get data stack.
     *
     * @param  array|null $data
     * @return array|self|null
     */
    public function data(array $data = null): array|self|null
    {
        if (func_num_args()) {
            return $this->setData($data);
        }
        return $this->getData();
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
     * Alias of count().
     *
     * @return int
     */
    public function size(): int
    {
        return $this->count();
    }

    /**
     * Get data stack.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data ?? [];
    }
}
