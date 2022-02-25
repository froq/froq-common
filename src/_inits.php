<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

// Global stuff.
{
    /**
     * Init Froq! global.
     */
    if (!isset($GLOBALS['@froq'])) {
        $GLOBALS['@froq'] = [];
    }

    /**
     * Set a global variable.
     *
     * @param  string $key
     * @param  any    $value
     * @return void
     */
    function set_global(string $key, $value)
    {
        $GLOBALS['@froq'][$key] = $value;
    }

    /**
     * Get a global variable/variables.
     *
     * @param  string   $key
     * @param  any|null $default
     * @return any|null
     */
    function get_global(string $key, $default = null)
    {
        // All.
        if ($key === '*') {
            $value = $GLOBALS['@froq'];
        }
        // All subs (eg: "foo*" or "foo.*").
        elseif ($key && $key[-1] === '*') {
            $values = [];
            $search = substr($key, 0, -1);
            foreach ($GLOBALS['@froq'] as $key => $value) {
                if ($search && str_starts_with($key, $search)) {
                    $values[$key] = $value;
                }
            }
            $value = $values;
        }
        // Sub only (eg: "foo" or "foo.bar").
        else {
            $value = $GLOBALS['@froq'][$key] ?? $default;
        }

        return $value;
    }

    /**
     * Delete a global variable.
     *
     * @param  string $key
     * @return void
     * @since  3.0
     */
    function delete_global(string $key)
    {
        unset($GLOBALS['@froq'][$key]);
    }
}

// System stuff.
{
    /**
     * Get an ini directive with bool option.
     *
     * @param  string   $name
     * @param  any|null $default
     * @param  bool     $bool
     * @return string|bool|null
     * @since  4.0
     */
    function ini(string $name, $default = null, bool $bool = false)
    {
        $value = (string) ini_get($name);
        if ($value === '') {
            $value = $default;
        }

        if ($bool) {
            $value = $value && in_array(
                strtolower($value), ['on', 'yes', 'true', '1'], true
            );
        }

        return $value;
    }

    /**
     * Get an environment variable.
     *
     * @param  string   $name
     * @param  any|null $default
     * @param  bool     $server_lookup
     * @return any|null
     * @since  4.0
     */
    function env(string $name, $default = null, bool $server_lookup = true)
    {
        $value = $_ENV[$name] ?? $_ENV[strtoupper($name)] ?? null;

        if ($value === null) {
            // Try with server global.
            if ($server_lookup) {
                $value = $_SERVER[$name] ?? $_SERVER[strtoupper($name)] ?? null;
            }

            if ($value === null) {
                // Try with getenv() (ini variable order issue).
                if (($value = getenv($name)) === false &&
                    ($value = getenv(strtoupper($name))) === false) {
                    $value = null;
                }
            }
        }

        return $value ?? $default;
    }
}

// Casting utility stuff.
{
    /**
     * Int caster.
     *
     * @param  any  $in
     * @param  bool $abs
     * @return int
     * @since  3.0
     */
    function int($in, bool $abs = false): int
    {
        return !$abs ? (int) $in : abs((int) $in);
    }

    /**
     * Float caster.
     *
     * @param  any $in
     * @param  int $precision
     * @return float
     * @since  3.0
     */
    function float($in, int $precision = 0): float
    {
        return !$precision ? (float) $in : round((float) $in, $precision);
    }

    /**
     * String caster.
     *
     * @param  any  $in
     * @param  bool $trim
     * @return string
     * @since  3.0
     */
    function string($in, bool $trim = false): string
    {
        return !$trim ? (string) $in : trim((string) $in);
    }

    /**
     * Bool caster.
     *
     * @param  any $in
     * @return bool
     * @since  3.0
     */
    function bool($in): bool
    {
        return (bool) $in;
    }

    /* function array(): array {} // :( */

    /**
     * Object caster.
     *
     * @param  object|array|null $in
     * @return object
     * @since  3.0
     */
    function object($in = null): object
    {
        return (object) $in;
    }
}

// Merge/append/prepend/aggregate.
{
    /**
     * Merge given values with given array.
     *
     * @param  array    $array
     * @param  any   ...$values
     * @return array
     * @since  4.0
     */
    function merge(array $array, ...$values): array
    {
        return array_merge($array, ...array_map(fn($value) => (array) $value, $values));
    }

    /**
     * Aggregate given array, optionally with a carry.
     *
     * @param  array      $array
     * @param  callable   $func
     * @param  array|null $carry
     * @return array
     * @since  4.4
     */
    function aggregate(array $array, callable $func, array $carry = null): array
    {
        return array_aggregate($array, $func, $carry);
    }

    /**
     * Append given values to given array.
     *
     * @param  array &$array
     * @param  ...    $values
     * @return array
     * @since  4.0
     */
    function append(array &$array, ...$values): array
    {
        return array_append($array, ...$values);
    }

    /**
     * Prepend given values to given array.
     *
     * @param  array &$array
     * @param  ...    $values
     * @return array
     * @since  4.0
     */
    function prepend(array &$array, ...$values): array
    {
        return array_prepend($array, ...$values);
    }
}
