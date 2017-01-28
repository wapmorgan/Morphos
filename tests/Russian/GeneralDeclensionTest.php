<?php
namespace morhos\test\Russian;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\GeneralDeclension;
use PHPUnit\Framework\TestCase;

class GeneralDeclensionTest extends TestCase {
    protected $dec;

    public function setUp() {
        $this->dec = new GeneralDeclension();
    }

    /**
     * @dataProvider wordsProvider
     */
    public function testDeclensionDetect($word, $animateness, $declension) {
        $this->assertEquals($declension, $this->dec->getDeclension($word));
    }

    /**
     * @dataProvider wordsProvider
     */
    public function testDeclenation($word, $animateness, $declension, $declenated) {
        $this->assertEquals($declenated, array_values($this->dec->getForms($word, $animateness)));
    }

    /**
     * @dataProvider wordsProvider
     */
    public function testPluralDeclenation($word, $animateness, $declension, $declenated, $pluralizedAndDeclenated) {
        $this->assertEquals($pluralizedAndDeclenated, array_values($this->dec->pluralizeAllDeclensions($word, $animateness)));
    }

    public function wordsProvider() {
        return array(
            array('дом', false, 1, array('дом', 'дома', 'дому', 'дом', 'домом', 'доме'), array('дома', 'домов', 'домам', 'дома', 'домами', 'домах')),
            array('поле', false, 1, array('поле', 'поля', 'полю', 'поле', 'полем', 'поле'), array('поля', 'полей', 'полям', 'поля', 'полями', 'полях')),
            array('гвоздь', false, 1, array('гвоздь', 'гвоздя', 'гвоздю', 'гвоздь', 'гвоздем', 'гвозде'), array('гвоздя', 'гвоздей', 'гвоздям', 'гвоздя', 'гвоздями', 'гвоздях')),
            array('гений', true, 1, array('гений', 'гения', 'гению', 'гения', 'гением', 'гении'), array('гения', 'гениев', 'гениям', 'гениев', 'гениями', 'гениях')),
            array('молния', false, 2, array('молния', 'молнии', 'молние', 'молнию', 'молнией', 'молние'), array('молния', 'молнией', 'молниям', 'молния', 'молниями', 'молниях')),
        );
    }
}
