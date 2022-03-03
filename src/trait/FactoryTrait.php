<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Factory Trait.
 *
 * A trait, for creating static or a single static instances from user classes.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\FactoryTrait
 * @author  Kerem Güneş
 * @since   5.0
 */
trait FactoryTrait
{
    /** @var self (static) */
    private static self $instance;

    /**
     * Create a static (user class) instance.
     *
     * @param  mixed ...$args
     * @return static
     */
    public static final function init(mixed ...$args): static
    {
        return new static(...$args);
    }

    /**
     * Create a static (user class) instance as singleton.
     *
     * @param  mixed ...$args
     * @return static
     */
    public static final function initOnce(mixed ...$args): static
    {
        return self::$instance ??= new static(...$args);
    }
}
