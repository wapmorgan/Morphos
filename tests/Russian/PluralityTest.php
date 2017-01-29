<?php
namespace morhos\test\Russian;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Plurality;

class PluralityTest extends \PHPUnit_Framework_TestCase {
    protected $plu;

    public function setUp() {
        $this->plu = new Plurality();
    }

    /**
     * @dataProvider pluralizationWordsProvider
     */
    public function testPluralization($word, $pluralized2, $pluralized5) {
        $this->assertEquals($pluralized2, Plurality::pluralize($word, 2));
        $this->assertEquals($pluralized5, Plurality::pluralize($word, 5));
    }

    public function pluralizationWordsProvider() {
        return array(
            array('дом', 'дома', 'домов'),
            array('поле', 'поля', 'полей'),
        );
    }

    /**
     * @dataProvider pluralWordsProvider
     */
    public function testPluralDeclenation($word, $animateness, $declenated) {
        $this->assertEquals($declenated, array_values($this->plu->getForms($word, $animateness)));
    }

    public function pluralWordsProvider() {
        return array(
            array('дом', false, array('дома', 'домов', 'домам', 'дома', 'домами', 'о домах')),
            array('поле', false, array('поля', 'полей', 'полям', 'поля', 'полями', 'о полях')),
            // array('ночь', false, array('ночи', 'ночей', 'ночам', 'ночи', 'ночами', 'о ночах')),
            // array('кирпич', false, array('кирпичи', 'кирпичей', 'кирпичам', 'кирпичи', 'кирпичами', 'о кирпичах')),
            array('гвоздь', false, array('гвоздя', 'гвоздей', 'гвоздям', 'гвоздя', 'гвоздями', 'о гвоздях')),
            array('гений', true, array('гения', 'гениев', 'гениям', 'гениев', 'гениями', 'о гениях')),
            array('молния', false, array('молния', 'молнией', 'молниям', 'молния', 'молниями', 'о молниях')),
        );
    }
}
