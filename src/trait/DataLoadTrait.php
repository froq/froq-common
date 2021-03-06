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
 * Represents a trait which carries `$data` property and is able to load/unload actions.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataLoadTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataLoadTrait
{
    /** @var array $data */
    protected array $data;

    /**
     * Load data stack.
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
     * Unload data stack.
     *
     * @return self
     */
    public function unload(): self
    {
        $this->data = [];

        return $this;
    }
}
