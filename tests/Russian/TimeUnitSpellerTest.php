<?php
namespace morphos\test\Russian;
require __DIR__.'/../../vendor/autoload.php';

use DateInterval;
use morphos\Russian\TimeUnitSpeller;

class TimeUnitSpellerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider intervalsProvider()
	 */
	public function testSpellInterval($interval, $options, $result)
	{
		$this->assertEquals($result, TimeUnitSpeller::spellInterval(new DateInterval($interval), $options));
	}

	public function intervalsProvider()
	{
		return
		[
			['P1Y5M10D', 0, '1 год 5 месяцев 10 дней'],
			['P10Y1MT5H', 0, '10 лет 1 месяц 5 часов'],
			['P3DT1H2M', 0, '3 дня 1 час 2 минуты'],
			['P10MT40M30S', 0, '10 месяцев 40 минут 30 секунд'],
			['P1Y5M10D', TimeUnitSpeller::SEPARATE, '1 год, 5 месяцев и 10 дней'],
			['P10Y1MT5H', TimeUnitSpeller::DIRECTION, '10 лет 1 месяц 5 часов назад'],
			['P3DT1H2M', TimeUnitSpeller::SEPARATE | TimeUnitSpeller::DIRECTION, '3 дня, 1 час и 2 минуты назад'],
			['P10MT40M30S', TimeUnitSpeller::SEPARATE, '10 месяцев, 40 минут и 30 секунд'],
		];
	}

	/**
	 * @dataProvider timeUnitsProvider()
	 */
	public function testSpellUnit($value, $unit, $result)
	{
		$this->assertEquals($result, TimeUnitSpeller::spellUnit($value, $unit));
	}

	public function timeUnitsProvider()
	{
		return
		[
			[5, TimeUnitSpeller::YEAR, '5 лет'],
			[5, TimeUnitSpeller::MONTH, '5 месяцев'],
			[5, TimeUnitSpeller::HOUR, '5 часов'],
			[5, TimeUnitSpeller::SECOND, '5 секунд'],
		];
	}
}
