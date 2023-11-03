<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\object;

/**
 * @package froq\common\object
 * @class   froq\common\object\RegistryException
 * @author  Kerem Güneş
 * @since   6.0
 */
class RegistryException extends \froq\common\Exception
{
    public static function forUsedIdAndLockedState(string $givenId, string $objectId): static
    {
        return new static(
            'Id %q is used for object %q with locked state, '.
            'call replace() instead to force it to change.',
            [$givenId, $objectId]
        );
    }
}
