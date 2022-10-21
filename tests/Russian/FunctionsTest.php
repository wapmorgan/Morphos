<?php

namespace morphos\test\Russian;

use morphos\Gender;
use morphos\Russian\Cases;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    /**
     * @dataProvider fullNamesProvider()
     */
    public function testGetNameCases($name, $gender, $name2, $name3, $name4, $name5, $name6)
    {
        $this->assertEquals([
            Cases::IMENIT  => $name,
            Cases::RODIT   => $name2,
            Cases::DAT     => $name3,
            Cases::VINIT   => $name4,
            Cases::TVORIT  => $name5,
            Cases::PREDLOJ => $name6,
        ], \morphos\Russian\getNameCases($name, $gender));

        // old-style call to inflectName()
        $this->assertEquals([
            Cases::IMENIT  => $name,
            Cases::RODIT   => $name2,
            Cases::DAT     => $name3,
            Cases::VINIT   => $name4,
            Cases::TVORIT  => $name5,
            Cases::PREDLOJ => $name6,
        ], \morphos\Russian\inflectName($name, $gender));
    }

    public function fullNamesProvider()
    {
        return
            [
                [
                    'Янаев Осип Андреевич',
                    Gender::MALE,
                    'Янаева Осипа Андреевича',
                    'Янаеву Осипу Андреевичу',
                    'Янаева Осипа Андреевича',
                    'Янаевым Осипом Андреевичем',
                    'Янаеве Осипе Андреевиче',
                ],
                [
                    'Молодыха Лариса Трофимовна',
                    Gender::FEMALE,
                    'Молодыхи Ларисы Трофимовны',
                    'Молодыхе Ларисе Трофимовне',
                    'Молодыху Ларису Трофимовну',
                    'Молодыхой Ларисой Трофимовной',
                    'Молодыхе Ларисе Трофимовне',
                ],
                [
                    'Вергун Илья Захарович',
                    Gender::MALE,
                    'Вергуна Ильи Захаровича',
                    'Вергуну Илье Захаровичу',
                    'Вергуна Илью Захаровича',
                    'Вергуном Ильей Захаровичем',
                    'Вергуне Илье Захаровиче',
                ],
                [
                    'Горюнова Таисия Романовна',
                    Gender::FEMALE,
                    'Горюновой Таисии Романовны',
                    'Горюновой Таисии Романовне',
                    'Горюнову Таисию Романовну',
                    'Горюновой Таисией Романовной',
                    'Горюновой Таисии Романовне',
                ],
                [
                    'Путинцева Антонина Карповна',
                    Gender::FEMALE,
                    'Путинцевой Антонины Карповны',
                    'Путинцевой Антонине Карповне',
                    'Путинцеву Антонину Карповну',
                    'Путинцевой Антониной Карповной',
                    'Путинцевой Антонине Карповне',
                ],

                [
                    'Янаев Осип',
                    Gender::MALE,
                    'Янаева Осипа',
                    'Янаеву Осипу',
                    'Янаева Осипа',
                    'Янаевым Осипом',
                    'Янаеве Осипе',
                ],
                ['Осип', Gender::MALE, 'Осипа', 'Осипу', 'Осипа', 'Осипом', 'Осипе'],

                // foreign names
                [
                    'Андерсен Ганс Христиан',
                    Gender::MALE,
                    'Андерсена Ганса Христиана',
                    'Андерсену Гансу Христиану',
                    'Андерсена Ганса Христиана',
                    'Андерсеном Гансом Христианом',
                    'Андерсене Гансе Христиане',
                ],
                [
                    'Милн Алан Александр',
                    Gender::MALE,
                    'Милна Алана Александра',
                    'Милну Алану Александру',
                    'Милна Алана Александра',
                    'Милном Аланом Александром',
                    'Милне Алане Александре',
                ],
                [
                    'Тосунян Анна Георгиевна',
                    Gender::FEMALE,
                    'Тосунян Анны Георгиевны',
                    'Тосунян Анне Георгиевне',
                    'Тосунян Анну Георгиевну',
                    'Тосунян Анной Георгиевной',
                    'Тосунян Анне Георгиевне',
                ],
            ];
    }

    /**
     * @dataProvider inflectNameProvider()
     */
    public function testInflectName($name, $case, $gender, $expected)
    {
        $this->assertEquals($expected, \morphos\Russian\inflectName($name, $case, $gender));
    }

    public function inflectNameProvider()
    {
        return
            [
                ['Янаев Осип Андреевич', Cases::GENITIVE, Gender::MALE, 'Янаева Осипа Андреевича'],
                ['Молодыха Лариса Трофимовна', Cases::DATIVE, Gender::FEMALE, 'Молодыхе Ларисе Трофимовне'],
                ['Вергун Илья Захарович', Cases::ACCUSATIVE, Gender::MALE, 'Вергуна Илью Захаровича'],
                ['Горюнова Таисия Романовна', Cases::ABLATIVE, Gender::FEMALE, 'Горюновой Таисией Романовной'],
                ['Путинцева Антонина Карповна', Cases::PREPOSITIONAL, Gender::FEMALE, 'Путинцевой Антонине Карповне'],

                // name parts
                ['Ганс', Cases::GENITIVE, Gender::MALE, 'Ганса'],
                ['Милн Алан', Cases::GENITIVE, Gender::MALE, 'Милна Алана'],
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
        $this->assertEquals(Gender::MALE, \morphos\Russian\detectGender('Иванов Петр Андреевич'));
        $this->assertEquals(Gender::MALE, \morphos\Russian\detectGender('Иванов Петр'));
        $this->assertEquals(Gender::MALE, \morphos\Russian\detectGender('Петр'));

        $this->assertEquals(Gender::FEMALE, \morphos\Russian\detectGender('Мирова Анастасия Карповна'));
        $this->assertEquals(Gender::FEMALE, \morphos\Russian\detectGender('Мирова Анастасия'));
        $this->assertEquals(Gender::FEMALE, \morphos\Russian\detectGender('Анастасия'));
    }

    public function testPluralize()
    {
        $this->assertEquals('10 сообщений', \morphos\Russian\pluralize(10, 'сообщение'));
        $this->assertEquals('10 ванных', \morphos\Russian\pluralize(10, 'ванная'));

        // complex pluralization
        $this->assertEquals('10 новых непрочитанных сообщений',
            \morphos\Russian\pluralize(10, 'новое непрочитанное сообщение'));
        $this->assertEquals('22 новых непрочитанных сообщения',
            \morphos\Russian\pluralize(22, 'новое непрочитанное сообщение'));
        $this->assertEquals('21 небольшая лампа', \morphos\Russian\pluralize(21, 'небольшая лампа'));

        // old-style call to pluralize()
        // @phpstan-ignore-next-line
        $this->assertEquals('10 сообщений', \morphos\Russian\pluralize('сообщение', 10));
    }

    /**
     */
    public function testNameInvalid()
    {
        $this->assertFalse(\morphos\Russian\inflectName('Вергун Илья Захарович Захарович', Cases::GENITIVE));
        $this->assertFalse(\morphos\Russian\getNameCases('Вергун Илья Захарович Захарович'));
        $this->assertNull(\morphos\Russian\detectGender('Вергун Илья Захарович Захарович'));
    }
}
