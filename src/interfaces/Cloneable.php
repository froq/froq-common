<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Cloneable.
 *
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Cloneable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
interface Cloneable
{
    /**
     * To clone.
     * @return static
     */
    public function toClone(): static;
}
