<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

use froq\reflection\{
    ReflectionClass as XReflectionClass,
    ReflectionObject as XReflectionObject
};
use ReflectionClass, ReflectionObject;

/**
 * A trait, able to reflect this instance as a class or an object reflection.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\ReflectTrait
 * @author  Kerem Güneş
 * @since   7.2
 */
trait ReflectTrait
{
    /**
     * Reflect this instance, as object by default.
     *
     * @param  bool $extended Reflect with extended reflection(s).
     * @return ReflectionClass|ReflectionObject|XReflectionClass|XReflectionObject
     */
    public function reflect(bool $extended = false)
        : ReflectionClass|ReflectionObject|XReflectionClass|XReflectionObject
    {
        return !$extended ? new ReflectionObject($this) : new \XReflectionObject($this);
    }
}
