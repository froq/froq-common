<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\exception;

use froq\common\trait\ThrowableTrait;

/**
 * @package froq\common\exception
 * @object  froq\common\exception\RuntimeException
 * @author  Kerem Güneş
 * @since   4.0
 */
class RuntimeException extends \RuntimeException
{
    use ThrowableTrait;
}
