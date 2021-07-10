<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Access Trait.
 *
 * Represents a trait which carries `$data` property and is useable with ArrayAccess implemented classes.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataAccessTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataAccessTrait
{
    /** @var array $data */
    protected array $data;

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetExists($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetSet($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetGet($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }
}
