<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Sizable.
 *
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Sizable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
interface Sizable
{
    /**
     * Size.
     * @return int
     */
    public function size(): int;
}
