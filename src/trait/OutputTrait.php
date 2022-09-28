<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * A trait, provides `$output` property and related methods.
 *
 * @package froq\common\trait
 * @object  froq\common\trait\OutputTrait
 * @author  Kerem Güneş
 * @since   6.0
 */
trait OutputTrait
{
    /** @var mixed */
    protected mixed $output;

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
