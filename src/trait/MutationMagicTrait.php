<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Mutation Magic Trait.
 *
 * Represents a trait entity which provides access method via magic methods for encapsulated properties
 * with/without strict option on user object.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\MutationMagicTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait MutationMagicTrait
{
    /** @var bool */
    protected bool $__strict = false;

    /**
     * Magic - set.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->$name = $value;
    }

    /**
     * Magic - get.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return null;
        }

        return $this->$name ?? null;
    }

    /**
     * Magic - isset.
     *
     * @param  string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return false;
        }

        return isset($this->$name);
    }

    /**
     * Magic - unset.
     *
     * @param  string $name
     * @return void
     */
    public function __unset(string $name): void
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        unset($this->$name);
    }
}
