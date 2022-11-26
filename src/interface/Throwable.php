<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @object  froq\common\interface\Throwable
 * @author  Kerem Güneş
 * @since   7.0
 */
interface Throwable
{
    /**
     * @return Throwable|null
     */
    public function getCause(): \Throwable|null;
}
