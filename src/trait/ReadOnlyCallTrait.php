<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Read-Only Call Trait.
 *
 * A trait, provides read-only state check call method if the user class has
 * `readOnlyCheck()` method (that defined in `ReadOnlyTrait` trait as well).
 *
 * @package froq\common\trait
 * @object  froq\common\trait\ReadOnlyCallTrait
 * @author  Kerem Güneş
 * @since   5.4, 5.7
 */
trait ReadOnlyCallTrait
{
    /**
     * Call read-only state check method if the user class has the checker method.
     *
     * @return void
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function readOnlyCall(): void
    {
        // Might not be exists for all user class.
        if (method_exists($this, 'readOnlyCheck')) {
            $this->readOnlyCheck();
        }
    }
}
