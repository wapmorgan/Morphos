<?php

namespace morphos\English;

use InvalidArgumentException;

class TimeSpeller extends \morphos\TimeSpeller
{
    /**
     * @var string[]
     * @phpstan-var array<string, string>
     */
    protected static $units = [
        self::YEAR   => 'year',
        self::MONTH  => 'month',
        self::DAY    => 'day',
        self::HOUR   => 'hour',
        self::MINUTE => 'minute',
        self::SECOND => 'second',
    ];

    /**
     * @param int $count
     * @param string $unit
     * @return string
     */
    public static function spellUnit($count, $unit)
    {
        if (!isset(static::$units[$unit])) {
            throw new InvalidArgumentException('Unknown time unit: ' . $unit);
        }

        return $count . ' ' . NounPluralization::pluralize(static::$units[$unit], $count);
    }
}
