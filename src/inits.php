<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
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
     * Set global.
     * @param  string $key
     * @param  any    $value
     * @return void
     */
    function set_global(string $key, $value)
    {
        $GLOBALS['@froq'][$key] = $value;
    }

    /**
     * Get global.
     * @param  string   $key
     * @param  any|null $default
     * @return any|null
     */
    function get_global(string $key, $default = null)
    {
        if ($key === '*') { // All.
            $value = $GLOBALS['@froq'];
        } elseif ($key[-1] === '*') { // All subs (eg: "foo*" or "foo.*").
            $values = [];
            $search = substr($key, 0, -1);
            foreach ($GLOBALS['@froq'] as $key => $value) {
                if ($search && strpos($key, $search) === 0) {
                    $values[$key] = $value;
                }
            }
            $value = $values;
        } else { // Sub only (eg: "foo" or "foo.bar").
            $value = $GLOBALS['@froq'][$key] ?? $default;
        }
        return $value;
    }

    /**
     * Delete global.
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
     * Ini.
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

        static $bools = ['on', 'yes', 'true', '1'];

        if ($bool) {
            $value = $value && in_array(strtolower($value), $bools);
        }

        return $value;
    }

    /**
     * Env.
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
                if (($value = getenv($name)) === false) {
                    if (($value = getenv(strtoupper($name))) === false) {
                        unset($value);
                    }
                }
            }
        }

        return $value ?? $default;
    }
}

// Casting utility stuff.
{
    /**
     * Int.
     * @param  numeric $in
     * @return int
     * @since  3.0
     */
    function int($in): int
    {
        return (int) $in;
    }

    /**
     * Float.
     * @param  numeric  $in
     * @param  int|null $precision
     * @return float
     * @since  3.0
     */
    function float($in, int $precision = null): float
    {
        return !$precision ? (float) $in : round((float) $in, $precision);
    }

    /**
     * String.
     * @param  scalar $in
     * @param  bool   $trim
     * @return string
     * @since  3.0
     */
    function string($in, bool $trim = false): string
    {
        return !$trim ? (string) $in : trim((string) $in);
    }

    /**
     * Bool.
     * @param  scalar $in
     * @return bool
     * @since  3.0
     */
    function bool($in): bool
    {
        return (bool) $in;
    }

    // function array(): array {} // :(

    /**
     * Object.
     * @param  object|array|null $in
     * @return object
     * @since  3.0
     */
    function object($in = null): object
    {
        return (object) $in;
    }

    /**
     * Void.
     * @param  any &...$ins
     * @return void
     * @since  3.0
     */
    function void(&...$ins): void
    {
        foreach ($ins as &$in) {
            $in = null;
        }
    }
}

// Filter/map/reduce.
{
    /**
     * Filter.
     * @param  array|object $in
     * @param  callable     $func
     * @param  array|string $keys
     * @return array|object
     * @since  3.0
     */
    function filter($in, callable $func = null, $keys = null)
    {
        // Prevent null errors.
        $in = $in ?? [];

        // Default function.
        $func = $func ?? fn($v) => $v !== null && $v !== '' && $v !== [];

        // Object check.
        if ($check = ($in instanceof stdClass)) {
            $in = (array) $in;
        }

        if (is_null($keys)) {
            $out = array_filter($in, $func);
        } else {
            $out = [];
            // Use key,value notation ('*' or true).
            $keys = ($keys == '*') ? array_keys($in) : $keys;
            foreach ($in as $key => $value) {
                in_array($key, $keys, true)
                    && $func($value, $key)
                        && $out[$key] = $value;
            }
        }

        return $check ? (object) $out : $out;
    }

    /**
     * Map.
     * @param  array|object $in
     * @param  callable     $func
     * @param  array|string $keys
     * @return array|object
     * @since  3.0
     */
    function map($in, callable $func, $keys = null)
    {
        // Prevent null errors.
        $in = $in ?? [];

        // Object check.
        if ($check = ($in instanceof stdClass)) {
            $in = (array) $in;
        }

        if (is_null($keys)) {
            $out = array_map($func, $in);
        } else {
            $out = [];
            // Use key,value notation ('*' or true).
            $keys = ($keys == '*') ? array_keys($in) : $keys;
            foreach ($in as $key => $value) {
                in_array($key, $keys, true)
                    && $out[$key] = $func($value, $key);
            }
        }

        return $check ? (object) $out : $out;
    }

    /**
     * Reduce.
     * @param  array|object  $in
     * @param  any           $out
     * @param  callable|null $func
     * @return any
     * @since  4.0
     */
    function reduce($in, $out = null, callable $func = null)
    {
        return is_array($out)
             ? array_agg((array) $in, $func, $out)
             : array_reduce((array) $in, $func, $out);
    }
}

// Append/prepend/merge.
{
    /**
     * Append.
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
     * Prepend.
     * @param  array &$array
     * @param  ...    $values
     * @return array
     * @since  4.0
     */
    function prepend(array &$array, ...$values): array
    {
        return array_prepend($array, ...$values);
    }

    /**
     * Merge.
     * @param  array $array
     * @param  ...   $values
     * @return array
     * @since  4.0
     */
    function merge(array $array, ...$values): array
    {
        return array_merge($array, ...array_map(fn($v) => (array) $v, $values));
    }
}

// Dirty debug (dump) tools.. :(
{
    function _ps($s) {
        if (is_null($s)) return 'NULL';
        if (is_bool($s)) return $s ? 'TRUE' : 'FALSE';
        return preg_replace('~\[(.+?):.+?:(private|protected)\]~', '[\1:\2]', print_r($s, true));
    }
    function _pd($s) {
        ob_start(); var_dump($s); $s = ob_get_clean();
        return preg_replace('~\["?(.+?)"?(:(private|protected))?\]=>\s+~', '[\1\2] => ', _ps(trim($s)));
    }
    function pre($s, $e=false) {
        echo "<pre>", _ps($s), "</pre>", "\n";
        $e && exit;
    }
    function prs($s, $e=false) {
        echo _ps($s), "\n";
        $e && exit;
    }
    function prd($s, $e=false) {
        echo _pd($s), "\n";
        $e && exit;
    }
}
