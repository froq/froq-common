<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, provides `$input` property and related methods.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\InputTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait InputTrait
{
    /** Input. */
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
        if (isset($this->input)) {
            return true;
        }

        try {
            // Just check for: "Typed property ... $input
            // must not be accessed before initialization".
            !$this->input;
            return true;
        } catch (\Error) {
            return false;
        }
    }
}
