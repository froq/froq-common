<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\interfaces;

/**
 * Runnable.
 *
 * @package froq\common\interfaces
 * @object  froq\common\interfaces\Runnable
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
interface Runnable
{
    /**
     * Run.
     * @return void
     */
    public function run(): void;
}
