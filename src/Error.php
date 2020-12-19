<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common;

use froq\common\trait\ThrowableTrait;
use Error as _Error;

/**
 * Error.
 *
 * @package froq\common
 * @object  froq\common\Error
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Error extends _Error
{
    use ThrowableTrait;
}
