<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Intable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Intable
 * @author  Kerem Güneş
 * @since   5.0
 */
interface Intable
{
    /**
     * To int.
     *
     * @return int
     */
    public function toInt(): int;
}
