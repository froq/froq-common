<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Boolable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Boolable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
interface Boolable
{
    /**
     * To bool.
     *
     * @return bool
     */
    public function toBool(): bool;
}
