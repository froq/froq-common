<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Mutation Trait.
 *
 * Represents a trait entity which provides access method for encapsulated properties with/without strict option
 * on user object.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\MutationTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait MutationTrait
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
    public function set(string $name, $value)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->{$name} = $value;
    }

    /**
     * Magic - get.
     *
     * @param  string $name
     * @return any|void
     */
    public function get(string $name)
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
    public function isset(string $name)
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
    public function unset(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->{$name} = null;
    }
}
