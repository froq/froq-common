<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Yieldable.
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Yieldable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
interface Yieldable
{
    /**
     * Yield.
     * @return iterable
     */
    public function yield(): iterable;
}
