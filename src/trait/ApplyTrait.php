<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use Closure;

/**
 * Apply Trait.
 *
 * A trait, able to access the hidden properties/methods for modify/call purposes
 * in owner class.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ApplyTrait
 * @author  Kerem Güneş
 * @since   4.0
 */
trait ApplyTrait
{
    /**
     * Apply a function binding user object for `$this` usage.
     *
     * @param  callable $func
     * @return self
     */
    public final function apply(callable $func): self
    {
        $func instanceof Closure || $func = Closure::fromCallable($func);

        $func->bindTo($this)->call($this);

        return $this;
    }
}
