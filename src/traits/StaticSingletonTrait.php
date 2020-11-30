<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Static Singleton Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\StaticSingletonTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait StaticSingletonTrait
{
    /**
     * Instance.
     * @var self (static)
     */
    private static self $instance;

    /**
     * Init.
     * @param  ... $args
     * @return self (static)
     */
    public static final function init(...$args): self
    {
        return self::$instance ??= new static(...$args);
    }

    /**
     * Get instance.
     * @alias of init()
     */
    public static final function getInstance(...$args)
    {
        return self::init(...$args);
    }
}
