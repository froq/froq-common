<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Mutation Magic Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\MutationMagicTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait MutationMagicTrait
{
    /**
     * Strict.
     * @var bool
     */
    protected bool $__strict = false;

    /**
     * Set.
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
     * Get.
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
     * Isset.
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
     * Unset.
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
