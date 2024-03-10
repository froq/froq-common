<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @class   froq\common\interface\Lengthable
 * @author  Kerem Güneş
 * @since   7.3
 */
interface Lengthable
{
    /**
     * @return int
     */
    public function length(): int;
}
