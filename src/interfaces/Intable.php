<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Intable.
 *
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Intable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
interface Intable
{
    /**
     * To int.
     * @return int
     */
    public function toInt(): int;
}
