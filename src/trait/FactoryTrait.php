<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Factory Trait.
 *
 * Represents a trait entity which is able to create static instances or a single static instance from user class.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\FactoryTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
trait FactoryTrait
{
    /** @var self (static) */
    private static self $instance;

    /**
     * Create a static instance.
     *
     * @param  ... $args
     * @return static
     */
    public static final function init(...$args): static
    {
        return new static(...$args);
    }

    /**
     * Create a single static instance.
     *
     * @param  ... $args
     * @return static
     */
    public static final function initSingle(...$args): static
    {
        return self::$instance ??= new static(...$args);
    }
}
