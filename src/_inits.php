<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-common
 */
declare(strict_types=1);

// Casting utility stuff.
{
    /**
     * Int caster.
     *
     * @param  any  $in
     * @param  bool $abs
     * @return int
     * @since  3.0
     */
    function int($in, bool $abs = false): int
    {
        return !$abs ? (int) $in : abs((int) $in);
    }

    /**
     * Float caster.
     *
     * @param  any $in
     * @param  int $precision
     * @return float
     * @since  3.0
     */
    function float($in, int $precision = 0): float
    {
        return !$precision ? (float) $in : round((float) $in, $precision);
    }

    /**
     * String caster.
     *
     * @param  any  $in
     * @param  bool $trim
     * @return string
     * @since  3.0
     */
    function string($in, bool $trim = false): string
    {
        return !$trim ? (string) $in : trim((string) $in);
    }

    /**
     * Bool caster.
     *
     * @param  any $in
     * @return bool
     * @since  3.0
     */
    function bool($in): bool
    {
        return (bool) $in;
    }

    /* function array(): array {} // :( */

    /**
     * Object caster.
     *
     * @param  object|array|null $in
     * @return object
     * @since  3.0
     */
    function object($in = null): object
    {
        return (object) $in;
    }
}
