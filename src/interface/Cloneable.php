<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Cloneable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Cloneable
 * @author  Kerem Güneş <k-gun@mail.com>
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
