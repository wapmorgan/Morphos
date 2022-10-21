<?php

namespace morphos;

use RuntimeException;

abstract class BasePluralization
{
    /**
     * @abstract
     * @param string $word
     * @param int $count
     *
     * @return string
     */
    public static function pluralize($word, $count = 2)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @abstract
     * @param string $word
     * @param string $case
     * @param bool $animateness
     *
     * @return string
     */
    public static function getCase($word, $case, $animateness = false)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @abstract
     * @param string $word
     * @param bool $animateness
     *
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($word, $animateness = false)
    {
        throw new RuntimeException('Not implemented');
    }
}
