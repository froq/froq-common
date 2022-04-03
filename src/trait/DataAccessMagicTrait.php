<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * A trait, provides magic-access methods for the classes defining `$data`
 * property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataAccessMagicTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataAccessMagicTrait
{
    /** @magic */
    public function __isset(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /** @magic */
    public function &__get(int|string $key): mixed
    {
        return $this->data[$key];
    }

    /** @magic */
    public function __set(int|string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    /** @magic */
    public function __unset(int|string $key): void
    {
        unset($this->data[$key]);
    }
}
