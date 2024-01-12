<?php

namespace morphos\test\Russian;

use morphos\Gender;
use morphos\Russian\RussianLanguage;
use PHPUnit\Framework\TestCase;

class RussianLanguageTest extends TestCase
{
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
                ['внес', Gender::FEMALE, 'внесла'],
                ['внесся', Gender::FEMALE, 'внеслась'],
            ];
    }

    public function testIn()
    {
        $this->assertEquals('в море', RussianLanguage::in('море'));
        $this->assertEquals('в фильме', RussianLanguage::in('фильме'));
        $this->assertEquals('во флаконе', RussianLanguage::in('флаконе'));
        $this->assertEquals('во Владивостоке', RussianLanguage::in('Владивостоке'));
    }

    public function testWith()
    {
        $this->assertEquals('с пола', RussianLanguage::with('пола'));
        $this->assertEquals('со шкафа', RussianLanguage::with('шкафа'));
        $this->assertEquals('со щами', RussianLanguage::with('щами'));
        $this->assertEquals('со снегом', RussianLanguage::with('снегом'));
        $this->assertEquals('с сестрой', RussianLanguage::with('сестрой'));
    }

    public function testAbout()
    {
        $this->assertEquals('о материи', RussianLanguage::about('материи'));
        $this->assertEquals('об одном', RussianLanguage::about('одном'));
        $this->assertEquals('обо всём', RussianLanguage::about('всём'));
    }
}
