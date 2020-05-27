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

namespace froq\common\traits;

/**
 * Mutation Magic Trait.
 * @package froq\common\traits
 * @object  froq\common\traits\MutationMagicTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
trait MutationMagicTrait
{
    /**
     * Strict.
     * @var bool
     */
    protected bool $__strict = false;

    /**
     * Set.
     * @param  string $name
     * @param  any    $value
     * @return void
     */
    public function __set(string $name, $value)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->{$name} = $value;
    }

    /**
     * Get.
     * @param  string $name
     * @return any|void
     */
    public function __get(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        return $this->{$name};
    }

    /**
     * Isset.
     * @param  string $name
     * @return bool|void
     */
    public function __isset(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        return $this->{$name} !== null;
    }

    /**
     * Unset.
     * @param  string $name
     * @return void
     */
    public function __unset(string $name)
    {
        if ($this->__strict && !property_exists($this, $name)) {
            return;
        }

        $this->{$name} = null;
    }
}
