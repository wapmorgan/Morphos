<?php
namespace morhos\test\Russian;
require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\Plurality;

class PluralityTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider pluralizationWordsProvider
     */
    public function testPluralization($word, $pluralized2, $pluralized5) {
        // One
        $this->assertEquals($word, Plurality::pluralize($word, 1));
        $this->assertEquals($word, Plurality::pluralize($word, 101));
        $this->assertEquals($word, Plurality::pluralize($word, 201));
        $this->assertEquals($word, Plurality::pluralize($word, 1501));

        // Two-Four
        $this->assertEquals($pluralized2, Plurality::pluralize($word, 2));
        $this->assertEquals($pluralized2, Plurality::pluralize($word, 23));
        $this->assertEquals($pluralized2, Plurality::pluralize($word, 104));
        $this->assertEquals($pluralized2, Plurality::pluralize($word, 1503));

        // Five
        $this->assertEquals($pluralized5, Plurality::pluralize($word, 5));
        $this->assertEquals($pluralized5, Plurality::pluralize($word, 211));
        $this->assertEquals($pluralized5, Plurality::pluralize($word, 520));
        $this->assertEquals($pluralized5, Plurality::pluralize($word, 1513));
    }

    public function pluralizationWordsProvider() {
        return array(
            array('дом', 'дома', 'домов'),
            array('поле', 'поля', 'полей'),
            array('яблоко', 'яблока', 'яблок'),
            array('море', 'моря', 'морей'),
            array('плечо', 'плеча', 'плеч'),
            array('стол', 'стола', 'столов'),
            array('нож', 'ножа', 'ножей'),
            array('плакса', 'плаксы', 'плакс'),
            array('ложка', 'ложки', 'ложек'),
            array('вилка', 'вилки', 'вилок'),
            array('чашка', 'чашки', 'чашек'),
            array('тарелка', 'тарелки', 'тарелок'),
            array('день', 'дня', 'дней'),
            array('ночь', 'ночи', 'ночей'),
            array('ядро', 'ядра', 'ядер'),
        );
    }

    /**
     * @dataProvider pluralWordsProvider
     */
    public function testPluralDeclenation($word, $animateness, $declenated) {
        $this->assertEquals($declenated, array_values(Plurality::getCases($word, $animateness)));
    }

    public function pluralWordsProvider() {
        return array(
            array('дом', false, array('дома', 'домов', 'домам', 'дома', 'домами', 'о домах')),
            array('склон', false, array('склоны', 'склонов', 'склонам', 'склоны', 'склонами', 'о склонах')),
            array('поле', false, array('поля', 'полей', 'полям', 'поля', 'полями', 'о полях')),
            array('ночь', false, array('ночи', 'ночей', 'ночам', 'ночи', 'ночами', 'о ночах')),
            array('кирпич', false, array('кирпичи', 'кирпичей', 'кирпичам', 'кирпичи', 'кирпичами', 'о кирпичах')),
            array('гвоздь', false, array('гвоздя', 'гвоздей', 'гвоздям', 'гвоздя', 'гвоздями', 'о гвоздях')),
            array('гений', true, array('гения', 'гениев', 'гениям', 'гениев', 'гениями', 'о гениях')),
            array('молния', false, array('молния', 'молний', 'молниям', 'молния', 'молниями', 'о молниях')),
            array('тысяча', false, array('тысячи', 'тысяч', 'тысячам', 'тысячи', 'тысячами', 'о тысячах')),
            array('сообщение', false, array('сообщения', 'сообщений', 'сообщениям', 'сообщения', 'сообщениями', 'о сообщениях')),
            array('копейка', false, array('копейки', 'копеек', 'копейкам', 'копейки', 'копейками', 'о копейках')),
            array('батарейка', false, array('батарейки', 'батареек', 'батарейкам', 'батарейки', 'батарейками', 'о батарейках')),
            array('письмо', false, array('письма', 'писем', 'письмам', 'письма', 'письмами', 'о письмах')),
            array('песец', true, array('песцы', 'песцов', 'песцам', 'песцов', 'песцами', 'о песцах')),
            array('пятно', false, array('пятна', 'пятен', 'пятнам', 'пятна', 'пятнами', 'о пятнах')),
            array('волчище', false, array('волчища', 'волчищ', 'волчищам', 'волчища', 'волчищами', 'о волчищах')),
            array('год', false, array('года', 'годов', 'годам', 'года', 'годами', 'о годах')),
            array('месяц', false, array('месяцы', 'месяцев', 'месяцам', 'месяцы', 'месяцами', 'о месяцах')),

            // Адъективное склонение
            // мужской род
            array('выходной', false, array('выходные', 'выходных', 'выходным', 'выходные', 'выходными', 'о выходных')),
            array('двугривенный', false, array('двугривенные', 'двугривенных', 'двугривенным', 'двугривенные', 'двугривенными', 'о двугривенных')),
            array('рабочий', true, array('рабочие', 'рабочих', 'рабочим', 'рабочих', 'рабочими', 'о рабочих')),
            // средний род
            array('животное', true, array('животные', 'животных', 'животным', 'животных', 'животными', 'о животных')),
            array('подлежащее', false, array('подлежащие', 'подлежащих', 'подлежащим', 'подлежащие', 'подлежащими', 'о подлежащих')),
            // женский род
            array('запятая', false, array('запятые', 'запятых', 'запятым', 'запятые', 'запятыми', 'о запятых')),
            array('горничная', true, array('горничные', 'горничных', 'горничным', 'горничных', 'горничными', 'о горничных')),
            array('заведующая', true, array('заведующие', 'заведующих', 'заведующим', 'заведующих', 'заведующими', 'о заведующих')),
        );
    }
}
