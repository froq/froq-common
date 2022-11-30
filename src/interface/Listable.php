<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @class   froq\common\interface\Listable
 * @author  Kerem Güneş
 * @since   5.0
 */
interface Listable
{
    /**
     * @return array
     */
    public function toList(): array;
}
