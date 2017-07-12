<?php
namespace morphos\Russian;

use InvalidArgumentException;

class TimeUnitSpeller extends \morphos\TimeUnitSpeller
{
	protected static $units = [
		self::YEAR => 'год',
		self::MONTH => 'месяц',
		self::DAY => 'день',
		self::HOUR => 'час',
		self::MINUTE => 'минута',
		self::SECOND => 'секунда',
	];

	const AGO = 'назад';
	const IN = 'через';

	const AND = 'и';

	const JUST_NOW = 'только что';

	public static function spellUnit($count, $unit)
	{
		if (!isset(self::$units[$unit]))
			throw new InvalidArgumentException('Unknown time unit: '.$unit);

		// special case for YEAR >= 5
		if ($unit == self::YEAR && Plurality::getNumeralForm($count) == Plurality::FIVE_OTHER)
			return $count.' лет';

		return $count.' '.pluralize(self::$units[$unit], $count);
	}
}
