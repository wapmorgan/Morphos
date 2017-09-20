<?php
namespace morhos\test\Russian;

require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\NounPluralization;

class NounPluralizationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider pluralizationWordsProvider
     */
    public function testPluralization($word, $pluralized2, $pluralized5)
    {
        // One
        $this->assertEquals($word, NounPluralization::pluralize($word, 1));
        $this->assertEquals($word, NounPluralization::pluralize($word, 101));
        $this->assertEquals($word, NounPluralization::pluralize($word, 201));
        $this->assertEquals($word, NounPluralization::pluralize($word, 1501));

        // Two-Four
        $this->assertEquals($pluralized2, NounPluralization::pluralize($word, 2));
        $this->assertEquals($pluralized2, NounPluralization::pluralize($word, 23));
        $this->assertEquals($pluralized2, NounPluralization::pluralize($word, 104));
        $this->assertEquals($pluralized2, NounPluralization::pluralize($word, 1503));

        // Five
        $this->assertEquals($pluralized5, NounPluralization::pluralize($word, 5));
        $this->assertEquals($pluralized5, NounPluralization::pluralize($word, 211));
        $this->assertEquals($pluralized5, NounPluralization::pluralize($word, 520));
        $this->assertEquals($pluralized5, NounPluralization::pluralize($word, 1513));
    }

    public function pluralizationWordsProvider()
    {
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
    public function testPluralInflection($word, $animateness, $inflected)
    {
        $this->assertEquals($inflected, array_values(NounPluralization::getCases($word, $animateness)));
    }

    public function pluralWordsProvider()
    {
        return array(
            array('дом', false, array('дома', 'домов', 'домам', 'дома', 'домами', 'домах')),
            array('склон', false, array('склоны', 'склонов', 'склонам', 'склоны', 'склонами', 'склонах')),
            array('поле', false, array('поля', 'полей', 'полям', 'поля', 'полями', 'полях')),
            array('ночь', false, array('ночи', 'ночей', 'ночам', 'ночи', 'ночами', 'ночах')),
            array('кирпич', false, array('кирпичи', 'кирпичей', 'кирпичам', 'кирпичи', 'кирпичами', 'кирпичах')),
            array('гвоздь', false, array('гвоздя', 'гвоздей', 'гвоздям', 'гвоздя', 'гвоздями', 'гвоздях')),
            array('гений', true, array('гения', 'гениев', 'гениям', 'гениев', 'гениями', 'гениях')),
            array('молния', false, array('молния', 'молний', 'молниям', 'молния', 'молниями', 'молниях')),
            array('тысяча', false, array('тысячи', 'тысяч', 'тысячам', 'тысячи', 'тысячами', 'тысячах')),
            array('сообщение', false, array('сообщения', 'сообщений', 'сообщениям', 'сообщения', 'сообщениями', 'сообщениях')),
            array('халат', false, array('халаты', 'халатов', 'халатам', 'халаты', 'халатами', 'халатах')),
            array('прожектор', false, array('прожекторы', 'прожекторов', 'прожекторам', 'прожекторы', 'прожекторами', 'прожекторах')),

            array('копейка', false, array('копейки', 'копеек', 'копейкам', 'копейки', 'копейками', 'копейках')),
            array('батарейка', false, array('батарейки', 'батареек', 'батарейкам', 'батарейки', 'батарейками', 'батарейках')),
            array('письмо', false, array('письма', 'писем', 'письмам', 'письма', 'письмами', 'письмах')),
            array('песец', true, array('песцы', 'песцов', 'песцам', 'песцов', 'песцами', 'песцах')),
            array('пятно', false, array('пятна', 'пятен', 'пятнам', 'пятна', 'пятнами', 'пятнах')),
            array('волчище', false, array('волчища', 'волчищ', 'волчищам', 'волчища', 'волчищами', 'волчищах')),
            array('год', false, array('года', 'годов', 'годам', 'года', 'годами', 'годах')),
            array('месяц', false, array('месяцы', 'месяцев', 'месяцам', 'месяцы', 'месяцами', 'месяцах')),
            array('новость', false, array('новости', 'новостей', 'новостям', 'новости', 'новостями', 'новостях')),
            array('тень', false, array('тени', 'теней', 'теням', 'тени', 'тенями', 'тенях')),

            // Адъективное склонение
            // мужской род
            array('выходной', false, array('выходные', 'выходных', 'выходным', 'выходные', 'выходными', 'выходных')),
            array('двугривенный', false, array('двугривенные', 'двугривенных', 'двугривенным', 'двугривенные', 'двугривенными', 'двугривенных')),
            array('рабочий', true, array('рабочие', 'рабочих', 'рабочим', 'рабочих', 'рабочими', 'рабочих')),
            // средний род
            array('животное', true, array('животные', 'животных', 'животным', 'животных', 'животными', 'животных')),
            array('подлежащее', false, array('подлежащие', 'подлежащих', 'подлежащим', 'подлежащие', 'подлежащими', 'подлежащих')),
            // женский род
            array('запятая', false, array('запятые', 'запятых', 'запятым', 'запятые', 'запятыми', 'запятых')),
            array('горничная', true, array('горничные', 'горничных', 'горничным', 'горничных', 'горничными', 'горничных')),
            array('заведующая', true, array('заведующие', 'заведующих', 'заведующим', 'заведующих', 'заведующими', 'заведующих')),
        );
    }
}
