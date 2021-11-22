<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data To-Array Trait.
 *
 * Represents a trait that provides `toArray()` and `array()` methods for those classes
 * hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataToArrayTrait
 * @author  Kerem Güneş
 * @since   5.7
 */
trait DataToArrayTrait
{
    /**
     * Get data array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @alias of toArray()
     */
    public function array()
    {
        return $this->toArray();
    }
}
