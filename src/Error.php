<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common;

use froq\common\interface\Thrownable;
use froq\common\trait\ThrownableTrait;

/**
 * Base error class extended by all other Froq! error classes.
 *
 * @package froq\common
 * @class   froq\common\Error
 * @author  Kerem Güneş
 * @since   4.0
 */
class Error extends \Error implements Thrownable
{
    use ThrownableTrait;
}
