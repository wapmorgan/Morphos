<?php
namespace morhos\test\Russian;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\GeneralDeclension;

class GeneralDeclensionTest extends \PHPUnit_Framework_TestCase {
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
        $this->assertEquals($declenated, array_values(GeneralDeclension::getCases($word, $animateness)));
    }

    public function wordsProvider() {
        return array(
            // 1 - Женский, мужской род с окончанием [а, я].
            // 2 - Мужской рода с нулевым или окончанием [о, е],
            // 2 - Среднего рода с окончанием [о, е].
            // 3 - Женский род на мягкий и щипящий согласный.
            array('молния', false, 1, array('молния', 'молнии', 'молние', 'молнию', 'молнией', 'о молние')),
            array('папа', true, 1, array('папа', 'папы', 'папе', 'папу', 'папой', 'о папе')),
            array('слава', false, 1, array('слава', 'славы', 'славе', 'славу', 'славой', 'о славе')),
            array('пустыня', false, 1, array('пустыня', 'пустыни', 'пустыне', 'пустыню', 'пустыней', 'о пустыне')),
            array('вилка', false, 1, array('вилка', 'вилки', 'вилке', 'вилку', 'вилкой', 'о вилке')),
            array('тысяча', false, 1, array('тысяча', 'тысячи', 'тысяче', 'тысячу', 'тысячей', 'о тысяче')),
            array('копейка', false, 1, array('копейка', 'копейки', 'копейке', 'копейку', 'копейкой', 'о копейке')),
            array('батарейка', false, 1, array('батарейка', 'батарейки', 'батарейке', 'батарейку', 'батарейкой', 'о батарейке')),
            array('гривна', false, 1, array('гривна', 'гривны', 'гривне', 'гривну', 'гривной', 'о гривне')),

            array('дом', false, 2, array('дом', 'дома', 'дому', 'дом', 'домом', 'о доме')),
            array('поле', false, 2, array('поле', 'поля', 'полю', 'поле', 'полем', 'о поле')),
            array('кирпич', false, 2, array('кирпич', 'кирпича', 'кирпичу', 'кирпич', 'кирпичем', 'о кирпиче')),
            array('гвоздь', false, 2, array('гвоздь', 'гвоздя', 'гвоздю', 'гвоздь', 'гвоздем', 'о гвозде')),
            array('гений', true, 2, array('гений', 'гения', 'гению', 'гения', 'гением', 'о гении')),
            array('ястреб', true, 2, array('ястреб', 'ястреба', 'ястребу', 'ястреба', 'ястребом', 'о ястребе')),
            array('день', false, 2, array('день', 'дня', 'дню', 'день', 'днем', 'о дне')),
            array('склон', false, 2, array('склон', 'склона', 'склону', 'склон', 'склоном', 'о склоне')),
            array('сообщение', false, 2, array('сообщение', 'сообщения', 'сообщению', 'сообщение', 'сообщением', 'о сообщении')),
            array('общение', false, 2, array('общение', 'общения', 'общению', 'общение', 'общением', 'об общении')),
            array('воскрешение', false, 2, array('воскрешение', 'воскрешения', 'воскрешению', 'воскрешение', 'воскрешением', 'о воскрешении')),
            array('рубль', false, 2, array('рубль', 'рубля', 'рублю', 'рубль', 'рублем', 'о рубле')),
            array('доллар', false, 2, array('доллар', 'доллара', 'доллару', 'доллар', 'долларом', 'о долларе')),
            array('евро', false, 2, array('евро', 'евро', 'евро', 'евро', 'евро', 'о евро')),
            array('фунт', false, 2, array('фунт', 'фунта', 'фунту', 'фунт', 'фунтом', 'о фунте')),
            array('человек', true, 2, array('человек', 'человека', 'человеку', 'человека', 'человеком', 'о человеке')),
            array('бремя', false, 2, array('бремя', 'бремени', 'бремени', 'бремя', 'бременем', 'о бремени')),
            array('дитя', false, 2, array('дитя', 'дитяти', 'дитяти', 'дитя', 'дитятей', 'о дитяти')),
            array('путь', false, 2, array('путь', 'пути', 'пути', 'путь', 'путем', 'о пути')),
            // увеличительная форма
            array('волчище', true, 2, array('волчище', 'волчища', 'волчищу', 'волчище', 'волчищем', 'о волчище')),

            array('ночь', false, 3, array('ночь', 'ночи', 'ночи', 'ночь', 'ночью', 'о ночи')),
            array('новость', false, 3, array('новость', 'новости', 'новости', 'новость', 'новостью', 'о новости')),
        );
    }

    /**
     * @dataProvider immutableWordsProvider
     */
    public function testImmutableWords($word) {
        $this->assertFalse(GeneralDeclension::isMutable($word, false));
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
