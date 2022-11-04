<?php

namespace morphos;

use DateInterval;
use DateTime;
use RuntimeException;

abstract class TimeSpeller
{
    const YEAR   = 'year';
    const MONTH  = 'month';
    const DAY    = 'day';
    const HOUR   = 'hour';
    const MINUTE = 'minute';
    const SECOND = 'second';

    const AGO = 'ago';
    const IN  = 'in';

    const AND_WORD = 'and';

    const JUST_NOW = 'just now';

    const DIRECTION = 1;
    const SEPARATE  = 2;

    /**
     * @param int|string|DateTime $dateTime Unix timestamp
     *                                      or datetime in strtotime() format
     *                                      or DateTime instance
     *
     * @param int $options
     * @param int $limit
     *
     * @return string
     * @throws \Exception
     */
    public static function spellDifference($dateTime, $options = 0, $limit = 0)
    {
        $now = new DateTime('@' . time());

        if ($dateTime instanceof DateTime) {
            $interval = $dateTime->diff($now);
        } else {
            $date_time = new DateTime(is_numeric($dateTime)
                ? '@' . $dateTime
                : $dateTime);
            $interval  = $date_time->diff($now);
        }

        return static::spellInterval($interval, $options, $limit);
    }

    /**
     * @param DateInterval $interval
     * @param int $options
     * @param int $limit
     * @return string
     */
    public static function spellInterval(DateInterval $interval, $options = 0, $limit = 0)
    {
        $parts = [];
        $k     = 0;
        foreach ([
                     'y' => static::YEAR,
                     'm' => static::MONTH,
                     'd' => static::DAY,
                     'h' => static::HOUR,
                     'i' => static::MINUTE,
                     's' => static::SECOND,
                 ] as $interval_field => $unit) {
            if ($interval->{$interval_field} > 0) {
                if ($limit > 0 && $k >= $limit) {
                    break;
                }
                $parts[] = static::spellUnit($interval->{$interval_field}, $unit);
                $k++;
            }
        }

        if (empty($parts)) {
            return static::JUST_NOW;
        }

        if ($options & static::SEPARATE && count($parts) > 1) {
            $last_part = array_pop($parts);
            $spelled   = implode(', ', $parts) . ' ' . static::AND_WORD . ' ' . $last_part;
        } else {
            $spelled = implode(' ', $parts);
        }

        if ($options & static::DIRECTION) {
            if ($interval->invert) {
                $spelled = static::IN . ' ' . $spelled;
            } else {
                $spelled .= ' ' . static::AGO;
            }
        }

        return $spelled;
    }

    /**
     * @abstract
     * @param int $count
     * @param string $unit
     * @return string
     */
    public static function spellUnit($count, $unit)
    {
        throw new RuntimeException('Not implemented');
    }
}
