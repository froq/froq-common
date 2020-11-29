<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

use froq\common\Exception;

/**
 * Static Class Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\StaticClassTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.3
 */
trait StaticClassTrait
{
    /**
     * Constructor.
     * @throws froq\common\Exception
     */
    public final function __construct()
    {
        throw new Exception("Cannot initialize static class '%s'", static::class);
    }
}
