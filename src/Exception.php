<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common;

use froq\common\interface\Thrownable;
use froq\common\trait\ThrownableTrait;

/**
 * Base exception class extended by all other Froq! exception classes.
 *
 * @package froq\common
 * @object  froq\common\Exception
 * @author  Kerem Güneş
 * @since   4.0
 */
class Exception extends \Exception implements Thrownable
{
    use ThrownableTrait;
}
