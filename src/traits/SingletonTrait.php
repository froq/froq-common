<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Singleton Trait.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\SingletonTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
trait SingletonTrait
{
    /**
     * Instance.
     * @var self
     */
    private static self $instance;

    /**
     * Init.
     * @param  ... $args
     * @return self
     */
    public static final function init(...$args): self
    {
        return self::$instance ??= new self(...$args);
    }

    /**
     * Get instance.
     * @alias of init()
     * @since 4.0
     */
    public static final function getInstance(...$args)
    {
        return self::init(...$args);
    }
}
