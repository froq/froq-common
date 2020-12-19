<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Arrayable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Arrayable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
interface Arrayable
{
    /**
     * To array.
     *
     * @return array
     */
    public function toArray(): array;
}
