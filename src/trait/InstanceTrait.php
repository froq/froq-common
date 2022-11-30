<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, used for implementing Singleton pattern.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\InstanceTrait
 * @author  Kerem Güneş
 * @since   1.0, 5.0
 */
trait InstanceTrait
{
    /** Instance. */
    private static self $instance;

    /**
     * Initialize user object.
     *
     * @param  mixed ...$args
     * @return static
     */
    public static final function init(mixed ...$args): static
    {
        return self::$instance ??= new static(...$args);
    }

    /**
     * Get instance.
     *
     * @alias init()
     * @since 4.0
     */
    public static final function getInstance(...$args)
    {
        return self::init(...$args);
    }
}
