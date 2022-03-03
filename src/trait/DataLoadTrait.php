<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Load Trait.
 *
 * A trait, provides `load() and `unload()` methods for the classes define `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataLoadTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataLoadTrait
{
    /**
     * Load data array.
     *
     * @param  array $data
     * @return self
     */
    public function load(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Unload data array.
     *
     * @return self
     */
    public function unload(): self
    {
        $this->data = [];

        return $this;
    }
}
