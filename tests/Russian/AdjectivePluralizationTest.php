<?php

namespace morphos\test\Russian;

use morphos\Russian\AdjectivePluralization;
use PHPUnit\Framework\TestCase;

class AdjectivePluralizationTest extends TestCase
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
        $this->assertEquals($inflected, array_values(AdjectivePluralization::getCases($word, $animateness)));
    }

    /**
     * @return array
     */
    public function wordsProvider()
    {
        return [
            ['адресный', false, ['адресные', 'адресных', 'адресным', 'адресные', 'адресными', 'адресных']],
            ['выездной', false, ['выездные', 'выездных', 'выездным', 'выездные', 'выездными', 'выездных']],
            ['домашний', false, ['домашние', 'домашних', 'домашним', 'домашние', 'домашними', 'домашних']],
            ['дилерский', false, ['дилерские', 'дилерских', 'дилерским', 'дилерские', 'дилерскими', 'дилерских']],
            ['сухой', false, ['сухие', 'сухих', 'сухим', 'сухие', 'сухими', 'сухих']],
            ['большой', false, ['большие', 'больших', 'большим', 'большие', 'большими', 'больших']],
        ];
    }
}
