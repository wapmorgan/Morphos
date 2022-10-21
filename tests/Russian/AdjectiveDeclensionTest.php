<?php

namespace morphos\test\Russian;

use morphos\Gender;
use morphos\Russian\AdjectiveDeclension;
use PHPUnit\Framework\TestCase;

class AdjectiveDeclensionTest extends TestCase
{

    /**
     * @dataProvider wordsProvider
     *
     * @param string $word
     * @param $animateness
     * @param $inflected
     */
    public function testInflection($word, $animateness, $inflected)
    {
        array_unshift($inflected, $word);
        $this->assertEquals($inflected, array_values(AdjectiveDeclension::getCases($word, $animateness)));
    }

    /**
     * @return array
     */
    public function wordsProvider()
    {
        return [
            ['адресный', false, ['адресного', 'адресному', 'адресный', 'адресным', 'адресном']],
            ['выездной', false, ['выездного', 'выездному', 'выездной', 'выездным', 'выездном']],
            ['адресное', false, ['адресного', 'адресному', 'адресное', 'адресным', 'адресном']],
            ['выездное', false, ['выездного', 'выездному', 'выездное', 'выездным', 'выездном']],
            ['адресная', false, ['адресной', 'адресной', 'адресную', 'адресной', 'адресной']],
            ['выездная', false, ['выездной', 'выездной', 'выездную', 'выездной', 'выездной']],
            ['домашний', false, ['домашнего', 'домашнему', 'домашний', 'домашним', 'домашнем']],
            ['домашнее', false, ['домашнего', 'домашнему', 'домашнее', 'домашним', 'домашнем']],
            ['домашняя', false, ['домашней', 'домашней', 'домашнюю', 'домашней', 'домашней']],
            ['дилерский', false, ['дилерского', 'дилерскому', 'дилерский', 'дилерским', 'дилерском']],
            ['сухой', false, ['сухого', 'сухому', 'сухой', 'сухим', 'сухом']],
            ['большой', false, ['большого', 'большому', 'большой', 'большим', 'большом']],
            ['дилерское', false, ['дилерского', 'дилерскому', 'дилерское', 'дилерским', 'дилерском']],
            ['сухое', false, ['сухого', 'сухому', 'сухое', 'сухим', 'сухом']],
            ['большое', false, ['большого', 'большому', 'большое', 'большим', 'большом']],
            ['дилерская', false, ['дилерской', 'дилерской', 'дилерскую', 'дилерской', 'дилерской']],
            ['сухая', false, ['сухой', 'сухой', 'сухую', 'сухой', 'сухой']],
            ['большая', false, ['большой', 'большой', 'большую', 'большой', 'большой']],
        ];
    }

    /**
     * @dataProvider gendersProvider()
     */
    public function testGenderDetection($word, $gender)
    {
        $this->assertEquals($gender, AdjectiveDeclension::detectGender($word));
    }

    public function gendersProvider()
    {
        return [
            ['синяя', Gender::FEMALE],
            ['весёлая', Gender::FEMALE],
            ['дилерский', Gender::MALE],
            ['большой', Gender::MALE],
            ['хмурое', Gender::NEUTER],
            ['весеннее', Gender::NEUTER],
        ];
    }
}
