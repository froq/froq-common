<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common;

use Exception as _Exception;

/**
 * Exception.
 *
 * @package froq\common
 * @object  froq\common\Exception
 * @author  Kerem Güneş
 * @since   4.0
 */
class Exception extends _Exception
{
    /** @see froq\common\trait\ThrowableTrait */
    use trait\ThrowableTrait;
}
