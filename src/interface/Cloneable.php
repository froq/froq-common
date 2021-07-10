<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Cloneable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Cloneable
 * @author  Kerem Güneş
 * @since   4.0
 */
interface Cloneable
{
    /**
     * Clone.
     *
     * @return static
     */
    public function clone(): static;
}
