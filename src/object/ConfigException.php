<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\object;

/**
 * @package froq\common\object
 * @class   froq\common\object\ConfigException
 * @author  Kerem Güneş
 * @since   6.0
 */
class ConfigException extends \froq\common\Exception
{
    public static function forAbsentDotEnvFile(string $file): static
    {
        return new static('No .env file exists such %q', $file);
    }

    public static function forReadDotEnvFileError(string $file): static
    {
        return new static('Cannot read .env file %q [error: @error]', $file, extract: true);
    }

    public static function forInvalidDotEnvEntry(string $entry, string $file, int $line): static
    {
        return new static('Invalid .env entry %q at %s:%s', [$entry, $file, $line]);
    }

    public static function forDuplicatedDotEnvEntry(string $entry, string $file, int $line): static
    {
        return new static('Duplicated .env entry %q at %s:%s', [$entry, $file, $line]);
    }
}
