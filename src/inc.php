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

// Ensure request scheme.
$_SERVER['REQUEST_SCHEME'] ??= 'http'. (($_SERVER['SERVER_PORT'] ?? '') == '443' ? 's' : '');

/**
 * Used to detect local env.
 * @const bool
 */
defined('local') or define('local', in_array(
    strrchr($_SERVER['SERVER_NAME'] ?? '', '.'), ['.local', '.localhost']
));

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
function set_global($key, $value)
{
    $GLOBALS['@froq'][$key] = $value;
}

/**
 * Get global.
 * @param  string $key
 * @param  any    $value_default
 * @return any
 */
function get_global($key, $value_default = null)
{
    $subs = ($key[-1] === '*'); // Is all?
    if ($subs) {
        $values = [];
        $search = substr($key, 0, -1);
        foreach ($GLOBALS['@froq'] as $key => $value) {
            if (strpos($key, $search) === 0) {
                $values[$key] = $value;
            }
        }
        $value = $values;
    } else {
        $value = $GLOBALS['@froq'][$key] ?? $value_default;
    }
    return $value;
}

/**
 * Delete global.
 * @param  string $key
 * @return void
 * @since  3.0
 */
function delete_global($key)
{
    unset($GLOBALS['@froq'][$key]);
}

// System functions.

/**
 * Ini.
 * @param  string $name
 * @param  bool   $bool
 * @return string|bool|null
 */
function ini(string $name, bool $bool = false)
{
    $value = ini_get($name);
    if (!$bool) {
        return $value;
    }

    static $bool_values = ['on', 'yes', 'true', '1'];

    $value = strtolower((string) $value);

    return in_array($value, $bool_values, true);
}

/**
 * Env.
 * @param  string|array  $key
 * @param  ?string|null  $value
 * @return ?string
 */
function env(string $key, ?string $value = null): ?string
{
    if ($value !== null) { // Set.
        $_ENV[$name] = $value;
    } else {               // Get.
        if (is_array($key)) {
            $keys = $key; $values = [];
            foreach ($keys as $key) {
                $values[] = env($key);
            }
            return $values;
        }

        // Uppers for nginx (in some cases).
        $value = $_ENV[$name] ?? $_ENV[strtoupper($name)] ??
                 $_SERVER[$name] ?? $_SERVER[strtoupper($name)] ?? $valueDefault;

        if ($value === null) {
            if (false === ($value = getenv($name))) {
                if (false === ($value = getenv(strtolower($name)))) {
                    $value = $valueDefault;
                }
            }
        }

        return $value;
    }
}

/**
 * Error.
 * @param  bool $extract
 * @return ?string
 */
function error(bool $extract = false): ?string
{
    $error = error_get_last()['message'] ?? 'Unknown';

    if ($error != null && $extract) {
        $error = strtolower($error);
        // Extract message part only.
        if (strpos($error, '(')) {
            $error = preg_replace('~(?:.*?:)?.*?:\s*(.+)~', '\1', $error);
        }
    }

    return $error;
}

// Util functions that could be used in cases if wanted,
// eg: int($var) instead (int) $var etc.

/**
 * Int.
 * @param  numeric $input
 * @return int
 * @since  3.0
 */
function int($input): int
{
    return (int) $input;
}

/**
 * Float.
 * @param  numeric  $input
 * @param  int|null $decimals
 * @return float
 * @since  3.0
 */
function float($input, int $decimals = null): float
{
    if ($decimals !== null) {
        $input = round($input, $decimals);
    }
    return (float) $input;
}

/**
 * String.
 * @param  scalar $input
 * @param  bool   $trim
 * @return string
 * @since  3.0
 */
function string($input, bool $trim = false): string
{
    return $trim ? trim((string) $input) : (string) $input;
}

/**
 * Bool.
 * @param  scalar $input
 * @return bool
 * @since  3.0
 */
function bool($input): bool
{
    return (bool) $input;
}

// function array(): array {} // :(

/**
 * Object.
 * @param  object|array|null $input
 * @return object
 * @since  3.0
 */
function object($input = null): object
{
    return (object) $input;
}

/**
 * Void.
 * @param  any &...$inputs
 * @return void
 * @since  3.0
 */
function void(&...$inputs): void
{
    foreach ($inputs as &$input) {
        $input = null;
    }
}

// Dirty debug (dump) tools.. :(

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

/**
 * Dump.
 * @aliasOf prd()
 */
function dump(...$args) { prd(...$args); }
