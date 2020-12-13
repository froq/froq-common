<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\common\traits;

/**
 * Data Magic Trait.
 *
 * Represents a trait which carries `$data` property and is able to set/get/isset/unset actions.
 *
 * @package froq\common\traits
 * @object  froq\common\traits\DataMagicTrait
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   5.0
 */
trait DataMagicTrait
{
    /** @var array $data */
    protected array $data;

    /**
     * Magic - set.
     *
     * @param  string $key
     * @param  any    $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Magic - get.
     *
     * @param  string $key
     * @return any|null
     */
    public function __get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Magic - isset.
     *
     * @param  string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Magic - unset.
     *
     * @param  string $key
     * @return void
     */
    public function __unset(string $key): void
    {
        unset($this->data[$key]);
    }
}
