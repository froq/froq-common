<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Arrayable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Arrayable
 * @author  Kerem Güneş
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
