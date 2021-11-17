<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * Sortable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Sortable
 * @author  Kerem Güneş
 * @since   5.2
 */
interface Sortable
{
    /**
     * Sort.
     *
     * @param  callable|null $func
     * @param  int           $flags
     * @return any
     */
    public function sort(callable $func = null, int $flags = 0);
}
