<?php

namespace morphos\test\Russian;

use morphos\Russian\NounPluralization;
use PHPUnit\Framework\TestCase;

class NounPluralizationTest extends TestCase
{

    /**
     * @dataProvider pluralizationWordsProvider
     *
     * @param string $word
     * @param $pluralized2
     * @param $pluralized5
     *
     * @throws \Exception
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
        return [
            ['дом', 'дома', 'домов'],
            ['поле', 'поля', 'полей'],
            ['яблоко', 'яблока', 'яблок'],
            ['море', 'моря', 'морей'],
            ['плечо', 'плеча', 'плеч'],
            ['стол', 'стола', 'столов'],
            ['нож', 'ножа', 'ножей'],
            ['плакса', 'плаксы', 'плакс'],
            ['ложка', 'ложки', 'ложек'],
            ['вилка', 'вилки', 'вилок'],
            ['чашка', 'чашки', 'чашек'],
            ['тарелка', 'тарелки', 'тарелок'],
            ['день', 'дня', 'дней'],
            ['ночь', 'ночи', 'ночей'],
            ['ядро', 'ядра', 'ядер'],

            ['рубль', 'рубля', 'рублей'],
            ['фунт', 'фунта', 'фунтов'],
            ['лира', 'лиры', 'лир'],
            ['крона', 'кроны', 'крон'],
            ['юань', 'юаня', 'юаней'],
            ['гривна', 'гривны', 'гривен'],

            // адъективное склонение
            ['ванная', 'ванных', 'ванных'],
            ['прохожий', 'прохожих', 'прохожих'],
        ];
    }

    /**
     * @dataProvider pluralizationWordsWithCaseProvider
     *
     * @param string $word
     * @param $pluralizedOne
     * @param $pluralizedMany
     *
     * @param string $case
     *
     * @throws \Exception
     */
    public function testPluralizationWithCase($word, $pluralizedOne, $pluralizedMany, $case)
    {
        // One
        $this->assertEquals($pluralizedOne, NounPluralization::pluralize($word, 1, false, $case));
        $this->assertEquals($pluralizedOne, NounPluralization::pluralize($word, 21, false, $case));
        $this->assertEquals($pluralizedOne, NounPluralization::pluralize($word, 101, false, $case));

        // Many
        $this->assertEquals($pluralizedMany, NounPluralization::pluralize($word, 3, false, $case));
        $this->assertEquals($pluralizedMany, NounPluralization::pluralize($word, 22, false, $case));
        $this->assertEquals($pluralizedMany, NounPluralization::pluralize($word, 60, false, $case));
    }

    public function pluralizationWordsWithCaseProvider()
    {
        return [
            // в ином падеже
            ['год', 'годе', 'годах', 'предложный'],
            ['товар', 'товару', 'товарам', 'дательный'],
        ];
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
        return [
            // 1 склонение
            ['дом', false, ['дома', 'домов', 'домам', 'дома', 'домами', 'домах']],
            ['склон', false, ['склоны', 'склонов', 'склонам', 'склоны', 'склонами', 'склонах']],
            ['поле', false, ['поля', 'полей', 'полям', 'поля', 'полями', 'полях']],
            ['ночь', false, ['ночи', 'ночей', 'ночам', 'ночи', 'ночами', 'ночах']],
            ['кирпич', false, ['кирпичи', 'кирпичей', 'кирпичам', 'кирпичи', 'кирпичами', 'кирпичах']],
            ['гвоздь', false, ['гвозди', 'гвоздей', 'гвоздям', 'гвозди', 'гвоздями', 'гвоздях']],
            ['молния', false, ['молния', 'молний', 'молниям', 'молния', 'молниями', 'молниях']],
            ['тысяча', false, ['тысячи', 'тысяч', 'тысячам', 'тысячи', 'тысячами', 'тысячах']],
            ['сообщение', false, ['сообщения', 'сообщений', 'сообщениям', 'сообщения', 'сообщениями', 'сообщениях']],
            ['халат', false, ['халаты', 'халатов', 'халатам', 'халаты', 'халатами', 'халатах']],
            [
                'прожектор',
                false,
                ['прожекторы', 'прожекторов', 'прожекторам', 'прожекторы', 'прожекторами', 'прожекторах'],
            ],
            ['пирсинг', false, ['пирсинги', 'пирсингов', 'пирсингам', 'пирсинги', 'пирсингами', 'пирсингах']],
            ['фабрика', false, ['фабрики', 'фабрик', 'фабрикам', 'фабрики', 'фабриками', 'фабриках']],
            ['гений', true, ['гения', 'гениев', 'гениям', 'гениев', 'гениями', 'гениях']],
            [
                'библиотекарь',
                true,
                ['библиотекари', 'библиотекарей', 'библиотекарям', 'библиотекарей', 'библиотекарями', 'библиотекарях'],
            ],
            ['лошадь', false, ['лошади', 'лошадей', 'лошадям', 'лошади', 'лошадями', 'лошадях']],
            ['любитель', true, ['любители', 'любителей', 'любителям', 'любителей', 'любителями', 'любителях']],
            ['матрас', false, ['матрасы', 'матрасов', 'матрасам', 'матрасы', 'матрасами', 'матрасах']],
            ['коттедж', false, ['коттеджы', 'коттеджей', 'коттеджам', 'коттеджы', 'коттеджами', 'коттеджах']],

            // 2 склонение
            ['копейка', false, ['копейки', 'копеек', 'копейкам', 'копейки', 'копейками', 'копейках']],
            ['штука', false, ['штуки', 'штук', 'штукам', 'штуки', 'штуками', 'штуках']],
            ['батарейка', false, ['батарейки', 'батареек', 'батарейкам', 'батарейки', 'батарейками', 'батарейках']],
            ['письмо', false, ['письма', 'писем', 'письмам', 'письма', 'письмами', 'письмах']],
            ['пятно', false, ['пятна', 'пятен', 'пятнам', 'пятна', 'пятнами', 'пятнах']],
            ['волчище', false, ['волчища', 'волчищ', 'волчищам', 'волчища', 'волчищами', 'волчищах']],
            ['год', false, ['года', 'лет', 'годам', 'года', 'годами', 'годах']],
            ['месяц', false, ['месяцы', 'месяцев', 'месяцам', 'месяцы', 'месяцами', 'месяцах']],
            ['новость', false, ['новости', 'новостей', 'новостям', 'новости', 'новостями', 'новостях']],
            ['тень', false, ['тени', 'теней', 'теням', 'тени', 'тенями', 'тенях']],
            ['человек', true, ['люди', 'человек', 'людям', 'людей', 'людьми', 'людях']],
            ['песец', true, ['песцы', 'песцов', 'песцам', 'песцов', 'песцами', 'песцах']],
            [
                'руководитель',
                true,
                ['руководители', 'руководителей', 'руководителям', 'руководителей', 'руководителями', 'руководителях'],
            ],
            ['голосование', true, ['голосования', 'голосований', 'голосованиям', 'голосований', 'голосованиями', 'голосованиях']],

            // 3 склонение
            ['дерево', false, ['деревья', 'деревьев', 'деревьям', 'деревья', 'деревьями', 'деревьях']],

            // Адъективное склонение
            // мужской род
            ['выходной', false, ['выходные', 'выходных', 'выходным', 'выходные', 'выходными', 'выходных']],
            [
                'двугривенный',
                false,
                ['двугривенные', 'двугривенных', 'двугривенным', 'двугривенные', 'двугривенными', 'двугривенных'],
            ],
            ['рабочий', true, ['рабочие', 'рабочих', 'рабочим', 'рабочих', 'рабочими', 'рабочих']],
            // средний род
            ['животное', true, ['животные', 'животных', 'животным', 'животных', 'животными', 'животных']],
            [
                'подлежащее',
                false,
                ['подлежащие', 'подлежащих', 'подлежащим', 'подлежащие', 'подлежащими', 'подлежащих'],
            ],
            // женский род
            ['запятая', false, ['запятые', 'запятых', 'запятым', 'запятые', 'запятыми', 'запятых']],
            ['горничная', true, ['горничные', 'горничных', 'горничным', 'горничных', 'горничными', 'горничных']],
            ['заведующая', true, ['заведующие', 'заведующих', 'заведующим', 'заведующих', 'заведующими', 'заведующих']],
        ];
    }
}
