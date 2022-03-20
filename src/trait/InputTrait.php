<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * A trait, defines `$options` property and provides `setInput()`, `getInput()`
 * and `hasInput()` methods.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\InputTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait InputTrait
{
    /** @var mixed */
    protected mixed $input;

    /**
     * Set input.
     *
     * @param  mixed $input
     * @return self
     */
    public function setInput(mixed $input): self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input.
     *
     * @return mixed
     */
    public function getInput(): mixed
    {
        return $this->input;
    }

    /**
     * Has input.
     *
     * @return bool
     */
    public function hasInput(): bool
    {
        try {
            // Just for: "Typed property ... $input must not be
            // accessed before initialization".
            !$this->input;
            return true;
        } catch (\Error) {
            return false;
        }
    }

    /**
     * Check input.
     *
     * @param  string      $throwable
     * @param  string|null $message
     * @return void
     * @throws Throwable
     */
    public function checkInput(string $throwable = 'Exception', string $message = null): void
    {
        if (!$this->hasInput()) {
            throw new $throwable($message ?? sprintf(
                'No input given yet, call %s::setInput() first', static::class
            ));
        }
    }
}
