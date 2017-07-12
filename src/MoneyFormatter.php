<?php
namespace morphos;

abstract class MoneyFormatter implements Currency
{
	const SHORT_FORMAT = 'short';
	const NORMAL_FORMAT = 'normal';
	const CLARIFICATION_FORMAT = 'clarification';
	const DUPLICATION_FORMAT = 'duplication';

	abstract public static function format($value, $currency, $format = self::NORMAL_FORMAT);
}
