<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data To-Json Trait.
 *
 * Represents a trait that provides `toJson()` and `json()` methods for those classes
 * hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataToJsonTrait
 * @author  Kerem Güneş
 * @since   5.7
 */
trait DataToJsonTrait
{
    /**
     * Get data array as JSON string.
     *
     * @param  int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string
    {
        return (string) json_encode($this->data, $flags);
    }

    /**
     * @alias of toJson()
     */
    public function json(...$args)
    {
        return $this->toJson(...$args);
    }
}
