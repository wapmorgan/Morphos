<?php

namespace morphos\Russian;

use InvalidArgumentException;

class TimeSpeller extends \morphos\TimeSpeller
{
    const AGO = 'назад';
    const IN  = 'через';
    const AND_WORD = 'и';
    const JUST_NOW = 'только что';
    /**
     * @var string[]
     */
    protected static $units = [
        self::YEAR   => 'год',
        self::MONTH  => 'месяц',
        self::DAY    => 'день',
        self::HOUR   => 'час',
        self::MINUTE => 'минута',
        self::SECOND => 'секунда',
    ];

    /**
     * @param int $count
     * @param string $unit
     *
     * @return string
     * @throws \Exception
     */
    public static function spellUnit($count, $unit)
    {
        if (!isset(static::$units[$unit])) {
            throw new InvalidArgumentException('Unknown time unit: ' . $unit);
        }

//         if ($count === 1 && in_array($unit, [self::SECOND, self::MINUTE], true)) {
//             if ($unit === self::SECOND)
//                 return '1 секунду';
//             return '1 минуту';
//         }

        return pluralize($count, static::$units[$unit]);
    }
}
