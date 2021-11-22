<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data List Trait.
 *
 * Represents a trait that provides `isList()`, `toList()` and `list()` methods
 * for those classes hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataListTrait
 * @author  Kerem Güneş
 * @since   5.7
 */
trait DataListTrait
{
    /**
     * Check whether data array is a list.
     *
     * @return bool
     */
    public function isList(): bool
    {
        return is_list($this->data);
    }

    /**
     * Get data array as list.
     *
     * @return array
     */
    public function toList(): array
    {
        return array_values($this->data);
    }

    /**
     * @alias of toList()
     */
    public function list()
    {
        return $this->toList();
    }
}
