<?php
namespace morphos\English;

use InvalidArgumentException;

class TimeSpeller extends \morphos\TimeSpeller
{
    protected static $units = [
        self::YEAR => 'year',
        self::MONTH => 'month',
        self::DAY => 'day',
        self::HOUR => 'hour',
        self::MINUTE => 'minute',
        self::SECOND => 'second',
    ];

    /**
     * @param $count
     * @param $unit
     * @return string
     */
    public static function spellUnit($count, $unit)
    {
        if (!isset(static::$units[$unit])) {
            throw new InvalidArgumentException('Unknown time unit: '.$unit);
        }

        return $count.' '.NounPluralization::pluralize(static::$units[$unit], $count);
    }
}
