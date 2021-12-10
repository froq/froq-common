<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Iteratable-Reverse.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\IteratableReverse
 * @author  Kerem Güneş
 * @since   5.10
 */
interface IteratableReverse
{
    /**
     * @note   Return is permissive.
     * @return iterable
     */
    public function getReverseIterator(): iterable;
}
