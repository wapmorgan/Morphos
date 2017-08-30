<?php
namespace morphos\test\Russian;

require __DIR__.'/../../vendor/autoload.php';

use morphos\Gender;
use morphos\NumeralGenerator;
use morphos\Russian\Cases;
use morphos\Russian\CardinalNumeralGenerator;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider namesProvider()
	 */
	public function testInflectName($name, $gender, $name2, $name3, $name4, $name5, $name6)
	{
		$this->assertEquals([
			Cases::IMENIT => $name,
			Cases::RODIT => $name2,
			Cases::DAT => $name3,
			Cases::VINIT => $name4,
			Cases::TVORIT => $name5,
			Cases::PREDLOJ => $name6
		], \morphos\Russian\inflectName($name, null, $gender));
	}

	public function namesProvider()
	{
		return
			[
				['Янаев Осип Андреевич', Gender::MALE, 'Янаева Осипа Андреевича', 'Янаеву Осипу Андреевичу', 'Янаева Осипа Андреевича', 'Янаевым Осипом Андреевичем', 'о Янаеве Осипе Андреевиче'],
				['Молодыха Лариса Трофимовна', Gender::FEMALE, 'Молодыхи Ларисы Трофимовны', 'Молодыхе Ларисе Трофимовне', 'Молодыху Ларису Трофимовну', 'Молодыхой Ларисой Трофимовной', 'о Молодыхе Ларисе Трофимовне'],
				['Вергун Илья Захарович', Gender::MALE, 'Вергуна Ильи Захаровича', 'Вергуну Илье Захаровичу', 'Вергуна Илью Захаровича', 'Вергуном Ильей Захаровичем', 'о Вергуне Илье Захаровиче'],
                ['Горюнова Таисия Романовна', Gender::FEMALE, 'Горюновой Таисии Романовны', 'Горюновой Таисии Романовне', 'Горюнову Таисию Романовну', 'Горюновой Таисией Романовной', 'о Горюновой Таисии Романовне'],
                ['Путинцева Антонина Карповна', Gender::FEMALE, 'Путинцевой Антонины Карповны', 'Путинцевой Антонине Карповне', 'Путинцеву Антонину Карповну', 'Путинцевой Антониной Карповной', 'о Путинцевой Антонине Карповне'],

                // foreign names
                ['Андерсен Ганс Христиан', Gender::MALE, 'Андерсена Ганса Христиана', 'Андерсену Гансу Христиану', 'Андерсена Ганса Христиана', 'Андерсеном Гансом Христианом', 'об Андерсене Гансе Христиане'],
                ['Милн Алан Александр', Gender::MALE, 'Милна Алана Александра', 'Милну Алану Александру', 'Милна Алана Александра', 'Милном Аланом Александром', 'о Милне Алане Александре'],
            ];
	}

    /**
     * @dataProvider verbsProvider()
     */
    public function testVerb($verb, $gender, $correctVerb)
    {
        $this->assertEquals($correctVerb, \morphos\Russian\RussianLanguage::verb($verb, $gender));
    }

    public function verbsProvider()
    {
        return
        [
            ['попал', Gender::MALE, 'попал'],
            ['попал', Gender::FEMALE, 'попала'],
            ['попался', Gender::MALE, 'попался'],
            ['попался', Gender::FEMALE, 'попалась'],
        ];
    }

    public function testDetectGender()
    {
        $this->assertEquals(Gender::MALE, \morphos\Russian\detectGender('Иванов Петр'));
        $this->assertEquals(Gender::FEMALE, \morphos\Russian\detectGender('Мирова Анастасия'));
    }

    public function testPluralize()
    {
        $this->assertEquals('10 сообщений', \morphos\Russian\pluralize(10, 'сообщение'));
    }
}
