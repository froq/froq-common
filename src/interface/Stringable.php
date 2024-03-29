<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @class   froq\common\interface\Stringable
 * @author  Kerem Güneş
 * @since   1.0
 */
interface Stringable
{
    /**
     * @return string
     */
    public function toString(): string;
}
