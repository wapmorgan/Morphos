<?php

namespace morphos;

use RuntimeException;

abstract class MoneySpeller implements Currency
{
    const SHORT_FORMAT         = 'short';
    const NORMAL_FORMAT        = 'normal';
    const CLARIFICATION_FORMAT = 'clarification';
    const DUPLICATION_FORMAT   = 'duplication';
    const ACCOUNTING_FORMAT    = 'accounting';

    /**
     * @abstract
     *
     * @param float|int $value
     * @param string $currency
     * @param string $format
     * @param string|null $case
     * @return string
     */
    public static function spell(
        $value,
        $currency,
        $format = self::NORMAL_FORMAT,
        $case = null,
        $skipFractionalPartIfZero = null
    ) {
        throw new RuntimeException('Not implemented');
    }
}
