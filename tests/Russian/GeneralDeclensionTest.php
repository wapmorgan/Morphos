<?php
namespace morhos\test\Russian;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\GeneralDeclension;

class GeneralDeclensionTest extends \PHPUnit_Framework_TestCase {
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
            array('дом', false, 1, array('дом', 'дома', 'дому', 'дом', 'домом', 'о доме'), array('дома', 'домов', 'домам', 'дома', 'домами', 'о домах')),
            array('поле', false, 1, array('поле', 'поля', 'полю', 'поле', 'полем', 'о поле'), array('поля', 'полей', 'полям', 'поля', 'полями', 'о полях')),
            // array('ночь', false, 2, array('ночь', 'ночи', 'ночи', 'ночь', 'ночью', 'о ночи'), array('ночи', 'ночей', 'ночам', 'ночи', 'ночами', 'о ночах')),
            // array('кирпич', false, 1, array('кирпич', 'кирпича', 'кирпичу', 'кирпич', 'кирпичем', 'о кирпиче'), array('кирпичи', 'кирпичей', 'кирпичам', 'кирпичи', 'кирпичами', 'о кирпичах')),
            array('гвоздь', false, 1, array('гвоздь', 'гвоздя', 'гвоздю', 'гвоздь', 'гвоздем', 'о гвозде'), array('гвоздя', 'гвоздей', 'гвоздям', 'гвоздя', 'гвоздями', 'о гвоздях')),
            array('гений', true, 1, array('гений', 'гения', 'гению', 'гения', 'гением', 'о гении'), array('гения', 'гениев', 'гениям', 'гениев', 'гениями', 'о гениях')),
            array('молния', false, 2, array('молния', 'молнии', 'молние', 'молнию', 'молнией', 'о молние'), array('молния', 'молнией', 'молниям', 'молния', 'молниями', 'о молниях')),
        );
    }

    /**
     * @dataProvider immutableWordsProvider
     */
    public function testImmutableWords($word) {
        $this->assertFalse($this->dec->hasForms($word, false));
    }

    public function immutableWordsProvider() {
        return array(
            array('авеню'),
            array('атташе'),
            array('бюро'),
            array('вето'),
            array('денди'),
            array('депо'),
            array('жалюзи'),
            array('желе'),
            array('жюри'),
            array('интервью'),
            array('какаду'),
            array('какао'),
            array('кафе'),
            array('кашне'),
            array('кенгуру'),
            array('кино'),
            array('клише'),
            array('кольраби'),
            array('коммюнике'),
            array('конферансье'),
            array('кофе'),
            array('купе'),
            array('леди'),
            array('меню'),
            array('метро'),
            array('пальто'),
            array('пенсне'),
            array('пианино'),
            array('плато'),
            array('портмоне'),
            array('рагу'),
            array('радио'),
            array('самбо'),
            array('табло'),
            array('такси'),
            array('трюмо'),
            array('фортепиано'),
            array('шимпанзе'),
            array('шоссе'),
            array('эскимо'),
            array('галифе'),
            array('монпансье'),
        );
    }
}
