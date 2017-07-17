<?php
namespace morphos;

abstract class MoneySpeller implements Currency
{
    const SHORT_FORMAT = 'short';
    const NORMAL_FORMAT = 'normal';
    const CLARIFICATION_FORMAT = 'clarification';
    const DUPLICATION_FORMAT = 'duplication';

	public static function spell($value, $currency, $format = self::NORMAL_FORMAT) {}
}
