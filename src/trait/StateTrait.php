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
    /**
     * Note: Private, so user class' subclasses (eg: Entity subclasses)
     * can define a property with name 'state' without signature check.
     *
     * @var State
     */
    private State $state;

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
     * @return array|object
     */
    public function getStates(bool $object = false): array|object
    {
        $states = (array) $this->state;

        return $object ? (object) $states : $states;
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
