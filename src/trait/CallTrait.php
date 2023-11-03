<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, provides `call()` method to call if user class has given method.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\CallTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait CallTrait
{
    /**
     * Call given method if user class has own it.
     *
     * @param  string    $method
     * @param  mixed  ...$methodArgs
     * @return mixed
     */
    public function call(string $method, mixed ...$methodArgs): mixed
    {
        if (method_exists($this, $method)) {
            return $this->$method(...$methodArgs);
        }
        return null;
    }
}
