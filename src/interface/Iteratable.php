<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Iteratable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Iteratable
 * @author  Kerem Güneş
 * @since   5.10
 */
interface Iteratable
{
    /**
     * @note   Return is permissive.
     * @return iterable
     */
    public function getIterator(): iterable;
}
