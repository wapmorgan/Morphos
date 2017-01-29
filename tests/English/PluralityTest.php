<?php
namespace morhos\test\English;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\English\Plurality;

class PluralityTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider wordsProvider
     */
    public function testPluralization($word, $pluralized) {
        $this->assertEquals($pluralized, Plurality::pluralize($word, 2));
    }

    public function wordsProvider() {
        return array(
            array('ship', 'ships'),
            array('gun', 'guns'),
            array('boy', 'boys'),
            array('class', 'classes'),
            array('box', 'boxes'),
            array('torpedo', 'torpedoes'),
            array('army', 'armies'),
            array('navy', 'navies'),
            array('wolf', 'wolves'),
            array('knife', 'knives'),
            array('chief', 'chiefs'),
            array('basis', 'bases'),
            array('crisis', 'crises'),
            array('radius', 'radii'),
            array('nucleus', 'nuclei'),
            array('curriculum', 'curricula'),
            array('man', 'men'),
            array('woman', 'women'),
            array('child', 'children'),
            array('foot', 'feet'),
            array('tooth', 'teeth'),
            array('ox', 'oxen'),
            array('goose', 'geese'),
            array('mouse', 'mice'),
            array('schoolboy', 'schoolboys'),
            array('knowledge', 'knowledge'),
            array('progress', 'progress'),
            array('advise', 'advise'),
            array('ink', 'ink'),
            array('money', 'money'),
            array('scissors', 'scissors'),
            array('spectacles', 'spectacles'),
            array('trousers', 'trousers'),
        );
    }
}
