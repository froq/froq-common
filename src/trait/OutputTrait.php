<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, provides `$output` property and related methods.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\OutputTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait OutputTrait
{
    /** Output. */
    protected mixed $output;

    /**
     * Reset output.
     *
     * @return void
     */
    public function resetOutput(): void
    {
        unset($this->output);
    }

    /**
     * Set output.
     *
     * @param  mixed $output
     * @return self
     */
    public function setOutput(mixed $output): self
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Get output.
     *
     * @return mixed
     */
    public function getOutput(): mixed
    {
        return $this->output;
    }

    /**
     * Has output.
     *
     * @return bool
     */
    public function hasOutput(): bool
    {
        if (isset($this->output)) {
            return true;
        }

        try {
            // Just check for: "Typed property ... $output
            // must not be accessed before initialization".
            !$this->output;
            return true;
        } catch (\Error) {
            return false;
        }
    }
}
