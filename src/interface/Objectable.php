<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Objectable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Objectable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
interface Objectable
{
    /**
     * To object.
     *
     * @return object
     */
    public function toObject(): object;
}
