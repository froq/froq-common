<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

use froq\collection\CollectionInterface;

/**
 * Collectable.
 *
 * @package froq\common\interface
 * @object  froq\common\interface\Collectable
 * @author  Kerem Güneş
 * @since   5.11
 */
interface Collectable
{
    /**
     * @return froq\collection\CollectionInterface
     */
    public function toCollection(): CollectionInterface;
}
