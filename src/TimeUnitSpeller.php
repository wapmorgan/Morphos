<?php
namespace morphos;

use DateInterval;

abstract class TimeUnitSpeller
{
	const YEAR = 'year';
	const MONTH = 'month';
	const DAY = 'day';
	const HOUR = 'hour';
	const MINUTE = 'minute';
	const SECOND = 'second';

	const AGO = 'ago';
	const IN = 'in';

	const AND = 'and';

	const JUST_NOW = 'just now';

	const DIRECTION = 1;
	const SEPARATE = 2;

	abstract public static function spellUnit($count, $unit);

	public static function spellInterval(DateInterval $interval, $options = 0)
	{
		$parts = [];
		foreach ([
			'y' => self::YEAR,
			'm' => self::MONTH,
			'd' => self::DAY,
			'h' => self::HOUR,
			'i' => self::MINUTE,
			's' => self::SECOND
		] as $interval_field => $unit) {
			if ($interval->{$interval_field} > 0)
				$parts[] = static::spellUnit($interval->{$interval_field}, $unit);
		}

		if (empty($parts))
			return static::JUST_NOW;

		if ($options & self::SEPARATE && count($parts) > 1) {
			$last_part = array_pop($parts);
			$spelled = implode(', ', $parts).' '.static::AND.' '.$last_part;
		} else
			$spelled = implode(' ', $parts);

		if ($options & self::DIRECTION) {
			if ($interval->invert)
				$spelled = static::IN.' '.$spelled;
			else
				$spelled .= ' '.static::AGO;
		}

		return $spelled;
	}
}
