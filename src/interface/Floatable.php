<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Floatable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Floatable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
interface Floatable
{
    /**
     * To float.
     *
     * @return float
     */
    public function toFloat(): float;
}
