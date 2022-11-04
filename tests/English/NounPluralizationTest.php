<?php

namespace morphos\test\English;

use morphos\English\NounPluralization;
use PHPUnit\Framework\TestCase;

class NounPluralizationTest extends TestCase
{
    /**
     * @dataProvider wordsProvider
     */
    public function testPluralization($word, $pluralized)
    {
        $this->assertEquals($pluralized, NounPluralization::pluralize($word, 2));
    }

    public function wordsProvider()
    {
        return [
            ['ship', 'ships'],
            ['gun', 'guns'],
            ['boy', 'boys'],
            ['class', 'classes'],
            ['box', 'boxes'],
            ['torpedo', 'torpedoes'],
            ['army', 'armies'],
            ['navy', 'navies'],
            ['wolf', 'wolves'],
            ['knife', 'knives'],
            ['chief', 'chiefs'],
            ['basis', 'bases'],
            ['crisis', 'crises'],
            ['radius', 'radii'],
            ['nucleus', 'nuclei'],
            ['curriculum', 'curricula'],
            ['man', 'men'],
            ['woman', 'women'],
            ['child', 'children'],
            ['foot', 'feet'],
            ['tooth', 'teeth'],
            ['ox', 'oxen'],
            ['goose', 'geese'],
            ['mouse', 'mice'],
            ['schoolboy', 'schoolboys'],
            ['knowledge', 'knowledge'],
            ['progress', 'progress'],
            ['advice', 'advice'],
            ['ink', 'ink'],
            ['money', 'money'],
            ['scissors', 'scissors'],
            ['spectacles', 'spectacles'],
            ['trousers', 'trousers'],
        ];
    }
}
