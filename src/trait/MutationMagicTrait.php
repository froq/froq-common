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
     * @param  any    $value
     * @return void
     */
    public function __set(string $name, $value)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->{$name} = $value;
    }

    /**
     * Magic - set.
     *
     * @param  string $name
     * @return any|void
     */
    public function __get(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        return $this->{$name};
    }

    /**
     * Magic - isset.
     *
     * @param  string $name
     * @return bool|void
     */
    public function __isset(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        return $this->{$name} !== null;
    }

    /**
     * Magic - unset.
     *
     * @param  string $name
     * @return void
     */
    public function __unset(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->{$name} = null;
    }
}
