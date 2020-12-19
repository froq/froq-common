<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\objects;

use froq\common\trait\StaticClassTrait;

/**
 * Static Class.
 *
 * Represents an uninitializable static class that forbid initializations of the extender classes.
 * We all wish it was a part of PHP but not (RFC: http://wiki.php.net/rfc/static-classes).
 *
 * @package froq\common\objects
 * @object  froq\common\objects\StaticClass
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 * @static  Not abstract'ed, letting the exception in constructor.
 */
class StaticClass
{
    /**
     * Static class trait.
     * @see froq\common\trait\StaticClassTrait
     */
    use StaticClassTrait;
}
