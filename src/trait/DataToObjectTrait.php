<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data To-Object Trait.
 *
 * Represents a trait that provides `toObject()` and `object()` methods for those classes
 * hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataToObjectTrait
 * @author  Kerem Güneş
 * @since   5.7
 */
trait DataToObjectTrait
{
    /**
     * Get data array as object (stdClass).
     *
     * @return object
     */
    public function toObject(): object
    {
        return (object) $this->data;
    }

    /**
     * @alias of toObject()
     */
    public function object()
    {
        return $this->toObject();
    }
}