<?php
namespace morphos\test\Russian;

require __DIR__.'/../../vendor/autoload.php';

use DateInterval;
use morphos\Russian\TimeSpeller;

class TimeSpellerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider intervalsProvider()
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
            ['P10MT40M30S', TimeSpeller::SEPARATE, '10 месяцев, 40 минут и 30 секунд'],
        ];
    }

    /**
     * @dataProvider timeUnitsProvider()
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
     * @expectedException InvalidArgumentException
     */
    public function testSpellUnitInvalid()
    {
        TimeSpeller::spellUnit(1, 'Invalid-Unit');
    }
}
