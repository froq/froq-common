<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Data Load Trait.
 *
 * Represents a trait which carries `$data` property and is able to load/unload actions.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\DataLoadTrait
 * @author  Kerem Güneş <k-gun@mail.com>
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
    public final function load(array $data): self
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
    public final function unload(): self
    {
        $this->data = [];

        return $this;
    }
}
