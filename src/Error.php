<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common;

use froq\common\trait\ThrowableTrait;

/**
 * Error.
 *
 * @package froq\common
 * @object  froq\common\Error
 * @author  Kerem Güneş
 * @since   4.0
 */
class Error extends \Error
{
    use ThrowableTrait;
}
