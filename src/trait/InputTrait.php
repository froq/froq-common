<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

namespace froq\common\trait;

/**
 * A trait, defines `$options` property and provides `setInput()`, `getInput()` methods.
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
}
