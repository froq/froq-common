<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\trait;

use Closure;

/**
 * Apply Trait.
 *
 * Represents a trait which is able to access the hidden properties/methods for modify/call
 * purposes in owner class.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ApplyTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait ApplyTrait
{
    /**
     * Apply.
     * @param  callable $func
     * @return self (static)
     */
    public final function apply(callable $func): self
    {
        if (!$func instanceof Closure) {
            $func = Closure::fromCallable($func);
        }

        $func->bindTo($this)->call($this);

        return $this;
    }
}
