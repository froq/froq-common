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
