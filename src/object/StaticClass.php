<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\object;

use froq\common\trait\StaticClassTrait;

/**
 * Static Class.
 *
 * Represents an uninitializable static class that forbid initializations of the extender classes.
 * We wish it was a part of PHP but not (RFC: http://wiki.php.net/rfc/static-classes).
 *
 * @package froq\common\object
 * @object  froq\common\object\StaticClass
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 * @static  Not abstract'ed, letting the exception in constructor.
 */
class StaticClass
{
    /**
     * @see froq\common\trait\StaticClassTrait
     */
    use StaticClassTrait;
}
