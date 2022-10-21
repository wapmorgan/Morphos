<?php

namespace morphos;

use RuntimeException;

abstract class NamesInflection implements Cases, Gender
{
    /**
     * @abstract
     * @param string $name
     * @param string $gender
     *
     * @return bool
     */
    public static function isMutable($name, $gender)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @abstract
     * @param string $name
     * @param string $gender
     *
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($name, $gender)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @abstract
     * @param string $name
     * @param string $case
     * @param string|null $gender
     *
     * @return string
     */
    public static function getCase($name, $case, $gender)
    {
        throw new RuntimeException('Not implemented');
    }
}
