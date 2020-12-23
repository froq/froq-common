<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Magic Trait.
 *
 * Represents a trait entity which carries `$data` property and is able to set/get/isset/unset actions.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataMagicTrait
 * @author  Kerem Güneş
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
    public function __set(string $key, $value)
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
    public function __isset(string $key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Magic - unset.
     *
     * @param  string $key
     * @return void
     */
    public function __unset(string $key)
    {
        unset($this->data[$key]);
    }
}
