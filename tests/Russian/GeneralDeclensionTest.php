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
        $this->assertEquals($declension, GeneralDeclension::getDeclension($word));
    }

    /**
     * @dataProvider wordsProvider
     */
    public function testDeclenation($word, $animateness, $declension, $declenated) {
        $this->assertEquals($declenated, array_values($this->dec->getForms($word, $animateness)));
    }

    public function wordsProvider() {
        return array(
            array('дом', false, 1, array('дом', 'дома', 'дому', 'дом', 'домом', 'о доме')),
            array('поле', false, 1, array('поле', 'поля', 'полю', 'поле', 'полем', 'о поле')),
            array('кирпич', false, 1, array('кирпич', 'кирпича', 'кирпичу', 'кирпич', 'кирпичем', 'о кирпиче')),
            array('гвоздь', false, 1, array('гвоздь', 'гвоздя', 'гвоздю', 'гвоздь', 'гвоздем', 'о гвозде')),
            array('гений', true, 1, array('гений', 'гения', 'гению', 'гения', 'гением', 'о гении')),
            array('ястреб', true, 1, array('ястреб', 'ястреба', 'ястребу', 'ястреба', 'ястребом', 'о ястребе')),
            array('день', false, 1, array('день', 'дня', 'дню', 'день', 'днем', 'о дне')),
            array('склон', false, 1, array('склон', 'склона', 'склону', 'склон', 'склоном', 'о склоне')),
            array('сообщение', false, 1, array('сообщение', 'сообщения', 'сообщению', 'сообщение', 'сообщением', 'о сообщение')),
            array('общение', false, 1, array('общение', 'общения', 'общению', 'общение', 'общением', 'об общение')),
            array('воскрешение', false, 1, array('воскрешение', 'воскрешения', 'воскрешению', 'воскрешение', 'воскрешением', 'о воскрешение')),
            array('молния', false, 2, array('молния', 'молнии', 'молние', 'молнию', 'молнией', 'о молние')),
            array('папа', true, 2, array('папа', 'папы', 'папе', 'папу', 'папой', 'о папе')),
            array('слава', false, 2, array('слава', 'славы', 'славе', 'славу', 'славой', 'о славе')),
            array('пустыня', false, 2, array('пустыня', 'пустыни', 'пустыне', 'пустыню', 'пустыней', 'о пустыне')),
            array('вилка', false, 2, array('вилка', 'вилки', 'вилке', 'вилку', 'вилкой', 'о вилке')),
            array('тысяча', false, 2, array('тысяча', 'тысячи', 'тысяче', 'тысячу', 'тысячей', 'о тысяче')),
            array('копейка', false, 2, array('копейка', 'копейки', 'копейке', 'копейку', 'копейкой', 'о копейке')),
            array('батарейка', false, 2, array('батарейка', 'батарейки', 'батарейке', 'батарейку', 'батарейкой', 'о батарейке')),
            array('ночь', false, 3, array('ночь', 'ночи', 'ночи', 'ночь', 'ночью', 'о ночи')),
            array('новость', false, 3, array('новость', 'новости', 'новости', 'новость', 'новостью', 'о новости')),
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
