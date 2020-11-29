<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common;

use froq\common\traits\ThrowableTrait;
use Exception as _Exception;

/**
 * Exception.
 *
 * @package froq\common
 * @object  froq\common\Exception
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Exception extends _Exception
{
    use ThrowableTrait;
}
