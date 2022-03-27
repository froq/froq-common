<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

use State;

/**
 * A trait, provides `$state` property, `setState()` and `getState()` methods.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\StateTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait StateTrait
{
    /** @var State */
    private State $state;

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
     * Reset states.
     *
     * @param  mixed ...$states
     * @return self
     */
    public function resetStates(mixed ...$states): self
    {
        $this->state->reset(...$states);

        return $this;
    }
}
