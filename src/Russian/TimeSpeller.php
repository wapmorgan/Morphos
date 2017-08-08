<?php
namespace morphos\Russian;

use InvalidArgumentException;

class TimeSpeller extends \morphos\TimeSpeller
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

    const AND_WORD = 'и';

    const JUST_NOW = 'только что';

    public static function spellUnit($count, $unit)
    {
        if (!isset(self::$units[$unit])) {
            throw new InvalidArgumentException('Unknown time unit: '.$unit);
        }

        // special case for YEAR >= 5
        if ($unit == self::YEAR && NounPluralization::getNumeralForm($count) == NounPluralization::FIVE_OTHER) {
            return $count.' лет';
        }

        return pluralize($count, self::$units[$unit]);
    }
}
