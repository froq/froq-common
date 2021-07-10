<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Instance Trait.
 *
 * Represents a trait entity that used for implementing Singleton pattern.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\InstanceTrait
 * @author  Kerem Güneş
 * @since   1.0, 5.0 Replaced with SingletonTrait.
 */
trait InstanceTrait
{
    /** @var self (static) */
    private static self $instance;

    /**
     * Initialize user object.
     *
     * @param  ... $args
     * @return static
     */
    public static final function init(...$args): static
    {
        return self::$instance ??= new static(...$args);
    }

    /**
     * Get instance.
     *
     * @alias of init()
     * @since 4.0
     */
    public static final function getInstance(...$args)
    {
        return self::init(...$args);
    }
}
