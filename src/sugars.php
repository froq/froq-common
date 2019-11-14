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
