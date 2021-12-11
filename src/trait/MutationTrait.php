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
     * Set.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function set(string $name, mixed $value): void
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->$name = $value;
    }

    /**
     * Get.
     *
     * @param  string $name
     * @return mixed
     */
    public function get(string $name): mixed
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return null;
        }

        return $this->$name ?? null;
    }

    /**
     * Isset.
     *
     * @param  string $name
     * @return bool
     */
    public function isset(string $name): bool
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return false;
        }

        return isset($this->$name);
    }

    /**
     * Unset.
     *
     * @param  string $name
     * @return void
     */
    public function unset(string $name): void
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        unset($this->$name);
    }
}
