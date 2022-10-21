<?php

namespace morphos\test\Russian;

use DateInterval;
use DateTime;
use InvalidArgumentException;
use morphos\Russian\TimeSpeller;
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
                ['P1Y5M10D', 0, '1 год 5 месяцев 10 дней'],
                ['P10Y1MT5H', 0, '10 лет 1 месяц 5 часов'],
                ['P3DT1H2M', 0, '3 дня 1 час 2 минуты'],
                ['P10MT40M30S', 0, '10 месяцев 40 минут 30 секунд'],
                ['P1Y5M10D', TimeSpeller::SEPARATE, '1 год, 5 месяцев и 10 дней'],
                ['P10Y1MT5H', TimeSpeller::DIRECTION, '10 лет 1 месяц 5 часов назад'],
                ['P3DT1H2M', TimeSpeller::SEPARATE | TimeSpeller::DIRECTION, '3 дня, 1 час и 2 минуты назад'],
                ['PT1M1S', TimeSpeller::SEPARATE | TimeSpeller::DIRECTION, '1 минута и 1 секунда назад'],
                ['P10MT40M30S', TimeSpeller::SEPARATE, '10 месяцев, 40 минут и 30 секунд'],
            ];
    }

    /**
     * @dataProvider timeUnitsProvider()
     * @throws \Exception
     */
    public function testSpellUnit($value, $unit, $result)
    {
        $this->assertEquals($result, TimeSpeller::spellUnit($value, $unit));
    }

    public function timeUnitsProvider()
    {
        return
            [
                [2, TimeSpeller::YEAR, '2 года'],
                [5, TimeSpeller::YEAR, '5 лет'],
                [105, TimeSpeller::YEAR, '105 лет'],
                [5, TimeSpeller::MONTH, '5 месяцев'],
                [5, TimeSpeller::HOUR, '5 часов'],
                [5, TimeSpeller::SECOND, '5 секунд'],
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
        $diff = (new DateTime('@' . time()))->diff(new DateTime(is_numeric($dateTime) ? '@' . $dateTime : $dateTime));
        $this->assertEquals(TimeSpeller::spellInterval($diff, 0, $limit),
            TimeSpeller::spellDifference($dateTime, 0, $limit));
    }

    public function differencesProvides()
    {
        return
            [
                ['+30 minutes 2 seconds', 1],
                [time() + 3600, 1],
                [time() + 86400, 1],
            ];
    }

    /**
     * @throws \Exception
     */
    public function testSpellUnitInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        TimeSpeller::spellUnit(1, 'Invalid-Unit');
    }
}
