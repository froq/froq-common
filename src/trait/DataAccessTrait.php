<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, provides related methods for the classes defining `$data`
 * property as array and implementing `ArrayAccess` interface.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\DataAccessTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataAccessTrait
{
    /** @inheritDoc ArrayAccess */
    public function offsetExists(mixed $key): bool
    {
        return isset($this->data[$key]);
    }

    /** @inheritDoc ArrayAccess */
    public function offsetSet(mixed $key, mixed $value): void
    {
        // Calls like `items[] = item`.
        if ($key === null) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    /** @inheritDoc ArrayAccess */
    public function &offsetGet(mixed $key): mixed
    {
        // Calls like `items[][] = item` will put
        // all nested items into a `["]` field.
        // So $key must be provided for base array.
        return $this->data[$key];
    }

    /** @inheritDoc ArrayAccess */
    public function offsetUnset(mixed $key): void
    {
        unset($this->data[$key]);
    }
}
