<?php

namespace morphos;

use RuntimeException;

abstract class BaseInflection implements Cases
{
    /**
     * @abstract
     * @param string $name
     * @return bool
     */
    public static function isMutable($name)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @abstract
     * @param string $name
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($name)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @abstract
     * @param string $name
     * @param string $case
     * @return string
     */
    public static function getCase($name, $case)
    {
        throw new RuntimeException('Not implemented');
    }
}
