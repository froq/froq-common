<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Stringable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Stringable
 * @author  Kerem Güneş
 * @since   3.12
 */
interface Stringable
{
    /**
     * To string.
     *
     * @return string
     */
    public function toString(): string;
}
