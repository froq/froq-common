<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\object;

/**
 * @package froq\common\object
 * @class   froq\common\object\EnumException
 * @author  Kerem Güneş
 * @since   6.0
 */
class EnumException extends \froq\common\Exception
{
    public static function forNoArrayCast(): static
    {
        return new static('Cannot cast array value to string');
    }

    public static function forNoValidCall(string $class, string $name): static
    {
        return new static(
            'No valid call as %s::%s(), call must be prefixed '.
            'with "is" and followed by an existing constant name',
            [$class, $name]
        );
    }

    public static function forNoValidConstant(string $class, string $constant): static
    {
        return new static(
            'No constant exists such %s::%s',
            [$class, $constant]
        );
    }

    public static function forNoValueGiven(): static
    {
        return new static('No value given in arguments');
    }

    public static function forInvalidCase(string $case): static
    {
        return new static('Invalid case %q', $case);
    }
}
