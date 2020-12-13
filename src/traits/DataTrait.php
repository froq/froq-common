<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Data Trait.
 *
 * Represents a trait which carries `$data` property and is able to set/get actions.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\DataTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
trait DataTrait
{
    /** @var array $data */
    protected array $data = [];

    /**
     * Set data property.
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
     * Get data property.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
