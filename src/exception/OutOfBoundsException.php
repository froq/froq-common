<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\exception;

use froq\common\interface\Thrownable;
use froq\common\trait\ThrownableTrait;

/**
 * @package froq\common\exception
 * @object  froq\common\exception\OutOfBoundsException
 * @author  Kerem Güneş
 * @since   4.0
 */
class OutOfBoundsException extends \OutOfBoundsException implements Thrownable
{
    use ThrownableTrait;
}
