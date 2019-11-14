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

namespace froq\core\traits;

use froq\core\Objects;

/**
 * Constant Trait.
 * @package froq\core\traits
 * @object  froq\core\traits\ConstantTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait ConstantTrait
{
    /**
     * Has constant.
     * @param  string $name
     * @return bool
     */
    public final function hasConstant(string $name): bool
    {
        return defined(static::class .'::'. $name);
    }

    /**
     * Get constant.
     * @param  string $name
     * @return ?array<string, any>
     */
    public final function getConstant(string $name): ?array
    {
        return Objects::getConstant($this, $name);
    }

    /**
     * Get constant value.
     * @param  string $name
     * @return any
     */
    public final function getConstantValue(string $name)
    {
        return Objects::getConstantValue($this, $name);
    }

    /**
     * Get constants.
     * @param  bool $all
     * @return ?array<string, array>
     */
    public final function getConstants(bool $all = true): ?array
    {
        return Objects::getConstants($this, $all);
    }

    /**
     * Get constant names.
     * @param  bool $all
     * @return ?array<string>
     */
    public final function getConstantNames(bool $all = true): ?array
    {
        return Objects::getConstantNames($this, $all);
    }
}
