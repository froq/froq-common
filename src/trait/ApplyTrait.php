<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

use Closure;

/**
 * A trait, able to access the hidden properties/methods for modify/call purposes
 * in owner class.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\ApplyTrait
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
    public function apply(callable $func): self
    {
        $func instanceof Closure || $func = Closure::fromCallable($func);

        $func->bindTo($this)->call($this);

        return $this;
    }
}
