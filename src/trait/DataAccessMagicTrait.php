<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Access Magic Trait.
 *
 * Represents a trait that provides some access & modify actions via magic methods
 * for those classes hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataAccessMagicTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait DataAccessMagicTrait
{
    /**
     * Magic - isset.
     *
     * @param  int|string $key
     * @return bool
     */
    public function __isset(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Magic - set.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return void
     */
    public function __set(int|string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Magic - get.
     *
     * @param  int|string $key
     * @return mixed
     */
    public function __get(int|string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Magic - unset.
     *
     * @param  int|string $key
     * @return void
     */
    public function __unset(int|string $key): void
    {
        unset($this->data[$key]);
    }
}
