<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * A trait, provides magic-access via offset methods for the classes defining
 * `$data` property as array and implementing `ArrayAccess` interface.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataAccessMagicOffsetTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait DataAccessMagicOffsetTrait
{
    /** @magic */
    public function __isset(int|string $key): bool
    {
        return $this->offsetExists($key);
    }

    /** @magic */
    public function __set(int|string $key, mixed $value): void
    {
        $this->offsetSet($key, $value);
    }

    /** @magic */
    public function &__get(int|string $key): mixed
    {
        return $this->offsetGet($key);
    }

    /** @magic */
    public function __unset(int|string $key): void
    {
        $this->offsetUnset($key);
    }
}
