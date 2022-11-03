<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @object  froq\common\interface\Serializable
 * @author  Kerem Güneş
 * @since   7.0
 */
interface Serializable
{
    /**
     * Serialize.
     *
     * @return string|false
     */
    public function serialize(): string|false

    /**
     * Unserialize.
     *
     * @param  string $data
     * @return bool @todo Use "true" type.
     */
    public function unserialize(string $data): bool
}
