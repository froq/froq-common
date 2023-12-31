<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\interface;

use froq\reflection\{
    ReflectionClass as XReflectionClass,
    ReflectionObject as XReflectionObject
};
use ReflectionClass, ReflectionObject;

/**
 * @package froq\common\interface
 * @class   froq\common\interface\Reflectable
 * @author  Kerem Güneş
 * @since   7.2
 */
interface Reflectable
{
    /**
     * @param  bool $extended Reflect with extended reflection(s).
     * @return ReflectionClass|ReflectionObject|XReflectionClass|XReflectionObject
     */
    public function reflect(bool $extended = false)
        : ReflectionClass|ReflectionObject|XReflectionClass|XReflectionObject;
}
