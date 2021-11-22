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
 * Represents a trait that provides some access & modify actions via implemented methods
 * for those classes hold a `$data` property as array and implement `ArrayAccess` interface.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataAccessTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataAccessTrait
{
    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetExists(mixed $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetGet(mixed $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public function offsetUnset(mixed $key): void
    {
        unset($this->data[$key]);
    }
}
