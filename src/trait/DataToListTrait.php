<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data To-List Trait.
 *
 * A trait, provides `toList()` and `list()` methods for the classes defining `$data`
 * property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataToListTrait
 * @author  Kerem Güneş
 * @since   5.7
 */
trait DataToListTrait
{
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
     * @alias toList()
     */
    public function list()
    {
        return $this->toList();
    }
}
