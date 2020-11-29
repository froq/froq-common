<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Sizeable.
 *
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Sizeable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
interface Sizeable
{
    /**
     * Size.
     * @return int
     */
    public function size(): int;
}
