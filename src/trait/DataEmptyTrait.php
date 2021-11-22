<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Empty Trait.
 *
 * Represents a trait that provides `empty()`, `isEmpty()` and `isNotEmpty()` methods
 * for those classes hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataEmptyTrait
 * @author  Kerem Güneş
 * @since   5.7
 */
trait DataEmptyTrait
{
    /**
     * Empty data array.
     *
     * @return self
     */
    public function empty(): self
    {
        $this->data = [];

        return $this;
    }

    /**
     * Check whether data array is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Check whether data array is not empty.
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !empty($this->data);
    }
}
