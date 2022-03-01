<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common;

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
    /** @see froq\common\trait\ThrowableTrait */
    use trait\ThrowableTrait;
}
