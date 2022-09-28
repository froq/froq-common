<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use State;

/**
 * A trait, provides `$state` property and related methods.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\StateTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait StateTrait
{
    /** @var State */
    protected State $state;

    /**
     * Init state.
     *
     * @param  mixed ...$states
     * @return self
     */
    public function initState(mixed ...$states): self
    {
        $this->state = new State(...$states);

        return $this;
    }

    /**
     * Check a state.
     *
     * @param  string $name
     * @return bool
     */
    public function hasState(string $name): bool
    {
        return $this->state->has($name);
    }

    /**
     * Set a state.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return self
     */
    public function setState(string $name, mixed $value): self
    {
        $this->state->set($name, $value);

        return $this;
    }

    /**
     * Get a state or default.
     *
     * @param  string     $name
     * @param  mixed|null $default
     * @return mixed|null
     */
    public function getState(string $name, mixed $default = null): mixed
    {
        return $this->state->get($name, $default);
    }

    /**
     * Remove a state.
     *
     * @param  string $name
     * @return self
     */
    public function removeState(string $name): self
    {
        $this->state->remove($name);

        return $this;
    }

    /**
     * Set states.
     *
     * @param  mixed ...$states
     * @return self
     */
    public function setStates(mixed ...$states): self
    {
        $this->state->reset(...$states);

        return $this;
    }

    /**
     * Get states.
     *
     * @param  bool $object
     * @return array|object
     */
    public function getStates(bool $object = false): array|object
    {
        $states = (array) $this->state;

        return $object ? (object) $states : $states;
    }

    /**
     * Remove states.
     *
     * @param  string ...$names
     * @return self
     */
    public function removeStates(string ...$names): self
    {
        $this->state->remove(...$names);

        return $this;
    }

    /**
     * Clear all states.
     *
     * @return self
     */
    public function clearStates(): self
    {
        $this->state->clear();

        return $this;
    }
}
