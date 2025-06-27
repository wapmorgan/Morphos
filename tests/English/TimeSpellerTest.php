<?php

namespace morphos\test\English;

use DateInterval;
use DateTime;
use InvalidArgumentException;
use morphos\English\TimeSpeller;
use PHPUnit\Framework\TestCase;

class TimeSpellerTest extends TestCase
{

    /**
     * @dataProvider intervalsProvider()
     *
     * @param $interval
     * @param $options
     * @param $result
     *
     * @throws \Exception
     */
    public function testSpellInterval($interval, $options, $result)
    {
        $this->assertEquals($result, TimeSpeller::spellInterval(new DateInterval($interval), $options));
    }

    public function intervalsProvider()
    {
        return
            [
                ['P1Y5M10D', 0, '1 year 5 months 10 days'],
                ['P10Y1MT5H', 0, '10 years 1 month 5 hours'],
                ['P3DT1H2M', 0, '3 days 1 hour 2 minutes'],
                ['P10MT40M30S', 0, '10 months 40 minutes 30 seconds'],
                ['P1Y5M10D', TimeSpeller::SEPARATE, '1 year, 5 months and 10 days'],
                ['P10Y1MT5H', TimeSpeller::DIRECTION, '10 years 1 month 5 hours ago'],
                ['P3DT1H2M', TimeSpeller::SEPARATE | TimeSpeller::DIRECTION, '3 days, 1 hour and 2 minutes ago'],
                ['P10MT40M30S', TimeSpeller::SEPARATE, '10 months, 40 minutes and 30 seconds'],
            ];
    }

    /**
     * @dataProvider timeUnitsProvider()
     *
     * @param $value
     * @param $unit
     * @param $result
     */
    public function testSpellUnit($value, $unit, $result)
    {
        $this->assertEquals($result, TimeSpeller::spellUnit($value, $unit));
    }

    public function timeUnitsProvider()
    {
        return
            [
                [1, TimeSpeller::YEAR, '1 year'],
                [5, TimeSpeller::YEAR, '5 years'],
                [5, TimeSpeller::MONTH, '5 months'],
                [5, TimeSpeller::HOUR, '5 hours'],
                [5, TimeSpeller::SECOND, '5 seconds'],
            ];
    }

    /**
     * @dataProvider differencesProvides()
     *
     * @param $dateTime
     * @param $limit
     *
     * @throws \Exception
     */
    public function testSpellDifference($dateTime, $limit)
    {
        $diff = (new DateTime())->diff(new DateTime(is_numeric($dateTime) ? '@' . $dateTime : $dateTime));
        $this->assertEquals(
            TimeSpeller::spellInterval($diff, 0, $limit),
            TimeSpeller::spellDifference($dateTime, 0, $limit),
            'DateTime is ' . $dateTime . ' and limit is ' . $limit
        );
    }

    public function differencesProvides()
    {
        return
            [
                ['+30 minutes 2 seconds', 1],
                [time() + 3602, 1],
                [time() + 86402, 1],
            ];
    }

    public function testSpellUnitInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        TimeSpeller::spellUnit(1, 'Invalid-Unit');
    }
}
