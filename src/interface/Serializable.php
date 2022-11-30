<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\interface;

/**
 * @package froq\common\interface
 * @class   froq\common\interface\Serializable
 * @author  Kerem Güneş
 * @since   7.0
 */
interface Serializable
{
    /**
     * Serialize.
     *
     * @return string|null
     */
    public function serialize(): string|null;

    /**
     * Unserialize.
     *
     * @param  string $data
     * @return bool @todo Use "true" type.
     */
    public function unserialize(string $data): bool;
}
