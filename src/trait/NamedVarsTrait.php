<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
namespace froq\common\trait;

/**
 * A trait, provides `__construct()` method to set named vars as properties.
 *
 * @package froq\common\trait
 * @class   froq\common\trait\NamedVarsTrait
 * @author  Kerem Güneş
 * @since   7.0
 */
trait NamedVarsTrait
{
    /**
     * Constructor.
     *
     * @param mixed ...$vars Map of named arguments.
     */
    public function __construct(mixed ...$vars)
    {
        foreach ($vars as $name => $value) {
            $this->$name = $value;
        }
    }
}
