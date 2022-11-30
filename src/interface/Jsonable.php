<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @class   froq\common\interface\Jsonable
 * @author  Kerem Güneş
 * @since   1.0
 */
interface Jsonable
{
    /**
     * @param  int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string;
}
