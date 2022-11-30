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
    /**
     * Create for absent dotenv file.
     *
     * @param  string $file
     * @return static
     */
    public static function forAbsentDotEnvFile(string $file): static
    {
        return new static('No .env file exists such %q', $file);
    }

    /**
     * Create for read dotenv file error.
     *
     * @param  string $file
     * @return static
     */
    public static function forReadDotEnvFileError(string $file): static
    {
        return new static('Cannot read .env file %q [error: @error]', $file, extract: true);
    }

    /**
     * Create for invalid dotenv entry.
     *
     * @param  string $entry
     * @param  string $file
     * @param  int    $line
     * @return static
     */
    public static function forInvalidDotEnvEntry(string $entry, string $file, int $line): static
    {
        return new static('Invalid .env entry %q at %s:%s', [$entry, $file, $line]);
    }

    /**
     * Create for duplicated dotenv entry.
     *
     * @param  string $entry
     * @param  string $file
     * @param  int    $line
     * @return static
     */
    public static function forDuplicatedDotEnvEntry(string $entry, string $file, int $line): static
    {
        return new static('Duplicated .env entry %q at %s:%s', [$entry, $file, $line]);
    }
}
