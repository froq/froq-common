<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * Data Iterator Trait.
 *
 * Represents a trait that provides `Iterator` interface methods for those classes
 * hold a `$data` property as array.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\DataIteratorTrait
 * @author  Kerem Güneş
 * @since   5.10
 */
trait DataIteratorTrait
{
    /** @inheritDoc Iterator */
    public function current(): mixed
    {
        return current($this->data);
    }

    /** @inheritDoc Iterator */
    public function next(): void
    {
        next($this->data);
    }

    /** @inheritDoc Iterator */
    public function rewind(): void
    {
        reset($this->data);
    }

    /** @inheritDoc Iterator */
    public function key(): int|string|null
    {
        return key($this->data);
    }

    /** @inheritDoc Iterator */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    /** @alias current() */
    public function value()
    {
        return $this->current();
    }

    /** @alias rewind() */
    public function reset()
    {
        $this->rewind();
    }
}
