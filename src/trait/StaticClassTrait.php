<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use froq\common\Exception;

/**
 * Static Class Trait.
 *
 * Represents a trait entity which is able to forbid initialions on user object.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\StaticClassTrait
 * @author  Kerem Güneş
 * @since   4.3
 */
trait StaticClassTrait
{
    /**
     * Constructor.
     *
     * @throws froq\common\Exception
     */
    public final function __construct()
    {
        throw new Exception('Cannot initialize static class ' . static::class);
    }
}
