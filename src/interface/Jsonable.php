<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Jsonable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Jsonable
 * @author  Kerem Güneş
 * @since   1.0
 */
interface Jsonable
{
    /**
     * To json.
     *
     * @param  int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string;
}
