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
     * @dataProvider wordsProvider
     */
    public function testPluralization($word, $pluralized2, $pluralized5) {
        $this->assertEquals($pluralized2, $this->plu->pluralize($word, 2));
        $this->assertEquals($pluralized5, $this->plu->pluralize($word, 5));
    }

    public function wordsProvider() {
        return array(
            array('дом', 'дома', 'домов'),
            array('поле', 'поля', 'полей'),
        );
    }
}
