<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\object;

use froq\collection\Collection;

/**
 * A config collection class.
 *
 * @package froq\common\object
 * @class   froq\common\object\Config
 * @author  Kerem Güneş
 * @since   1.0, 5.0
 */
class Config extends Collection
{
    /**
     * Update current options.
     *
     * @param  array $data
     * @return self
     * @since  4.0
     */
    public function update(array $data): self
    {
        $this->data = self::mergeSources($data, $this->data);

        return $this;
    }

    /**
     * Merge two config sources.
     *
     * @param  array $source1
     * @param  array $source2
     * @return array
     * @since  1.0, 4.0
     */
    public static function mergeSources(array $source1, array $source2): array
    {
        $ret = $source2;

        foreach ($source1 as $key => $value) {
            if (
                $value
                && is_array($value)
                && isset($source2[$key])
                && is_array($source2[$key])
            ) {
                $value = array_replace_recursive($source2[$key], $value);
            }

            $ret[$key] = $value;
        }

        return $ret;
    }

    /**
     * Parse a dot-env file and return its entries as options.
     *
     * @param  string $file
     * @param  bool   $cache
     * @return array
     * @throws froq\common\object\ConfigException
     */
    public static function parseDotEnvFile(string $file, bool $cache = false): array
    {
        if ($cache = $cache && function_exists('apcu_fetch')) {
            $key = md5('dotenv@' . $file);
            if ($ret = apcu_fetch($key)) {
                return $ret;
            }
        }

        $configs = [];

        $path = $file;
        if (!$file = realpath($file)) {
            throw ConfigException::forAbsentDotEnvFile($path);
        }

        $lines = @file($file);
        if ($lines === false) {
            throw ConfigException::forReadDotEnvFileError($file);
        }

        foreach ($lines as $i => $line) {
            $line = trim($line);

            // Skip empty & comment lines.
            if (!$line || $line[0] === '#') {
                continue;
            }

            $pairs = array_map('trim', explode('=', $line, 2));
            if (count($pairs) !== 2) {
                throw ConfigException::forInvalidDotEnvEntry($line, $file, $i + 1);
            }

            [$name, $value] = $pairs;
            if (isset($configs[$name])) {
                throw ConfigException::forDuplicatedDotEnvEntry($name, $file, $i + 1);
            }

            // Evaluate constant expressions to replace.
            if (preg_match('~\$\{(\w+)\}~', $value, $match) && defined($match[1])) {
                $value = str_replace($match[0], constant($match[1]), $value);
            }

            // Trim double quotes.
            $value = trim($value, '"');

            $configs[$name] = $value;
        }

        $cache && apcu_store($key, $configs);

        return $configs;
    }

    /**
     * Apply given dot-env configs.
     *
     * @param  array $configs
     * @param  bool  $global
     * @return void
     * @throws froq\common\object\ConfigException
     */
    public static function applyDotEnvConfigs(array $configs, bool $global = false): void
    {
        foreach ($configs as $name => $value) {
            if (!is_scalar($value)) {
                throw ConfigException::forNonScalarValue($name, $value);
            }

            $value = format_scalar($value, tsep: '');

            putenv($name . '=' . $value);

            // When it was set as true.
            $global && $_ENV[$name] = $value;
        }
    }
}
