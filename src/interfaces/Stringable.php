<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Stringable.
 *
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Stringable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   3.12
 */
interface Stringable
{
    /**
     * To string.
     * @return string
     */
    public function toString(): string;
}
