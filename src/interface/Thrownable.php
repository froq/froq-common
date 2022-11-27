<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @object  froq\common\interface\Thrownable
 * @author  Kerem Güneş
 * @since   7.0
 */
interface Thrownable
{
    /**
     * @return Throwable|null
     */
    public function getCause(): \Throwable|null;

    /**
     * @return array<Throwable>
     */
    public function getCauses(): array;
}
