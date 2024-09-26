<?php

namespace morphos\test\Russian;

use morphos\NamesInflection;
use morphos\Russian\Cases;
use morphos\Russian\LastNamesInflection;
use morphos\Russian\MiddleNamesInflection;
use PHPUnit\Framework\TestCase;

class MiddleNamesInflectionTest extends TestCase
{
    /**
     * @dataProvider middleNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6)
    {
        $forms = MiddleNamesInflection::getCases($name, $gender);
        $this->assertEquals([
            Cases::IMENIT => $name,
            Cases::RODIT => $name2,
            Cases::DAT => $name3,
            Cases::VINIT => $name4,
            Cases::TVORIT => $name5,
            Cases::PREDLOJ => $name6,
        ], $forms);
    }

    /**
     * @dataProvider middleNamesProvider()
     */
    public function testDetectGender($name, $gender)
    {
        $this->assertEquals($gender, MiddleNamesInflection::detectGender($name));
    }

    public function middleNamesProvider()
    {
        return [
            [
                'Владимирович',
                NamesInflection::MALE,
                'Владимировича',
                'Владимировичу',
                'Владимировича',
                'Владимировичем',
                'Владимировиче',
            ],
            [
                'Валерьянович',
                NamesInflection::MALE,
                'Валерьяновича',
                'Валерьяновичу',
                'Валерьяновича',
                'Валерьяновичем',
                'Валерьяновиче',
            ],
            [
                'Богдановна',
                NamesInflection::FEMALE,
                'Богдановны',
                'Богдановне',
                'Богдановну',
                'Богдановной',
                'Богдановне',
            ],
            ['Сергеевна', NamesInflection::FEMALE, 'Сергеевны', 'Сергеевне', 'Сергеевну', 'Сергеевной', 'Сергеевне'],
        ];
    }

    /**
     * @dataProvider mutableNamesProvider()
     */
    public function testMutableNames($name, $gender)
    {
        $this->assertTrue(MiddleNamesInflection::isMutable($name, $gender));
    }

    public function mutableNamesProvider()
    {
        return [
            ['Иванович', NamesInflection::MALE],
            ['Петровна', NamesInflection::FEMALE],
        ];
    }

    /**
     * @dataProvider middleNamesProvider()
     */
    public function testGetCase($name, $gender, $case2)
    {
        $this->assertEquals($case2, MiddleNamesInflection::getCase($name, Cases::RODIT, $gender));
    }

    /**
     * @dataProvider immutableNamesProvider()
     */
    public function testImmutable($name, $gender)
    {
        $this->assertFalse(MiddleNamesInflection::isMutable($name, $gender));
    }

    public function immutableNamesProvider()
    {
        return [
            ['А', NamesInflection::FEMALE],
        ];
    }
}
