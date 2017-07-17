<?php
namespace morhos\test\Russian;

require_once __DIR__.'/../../vendor/autoload.php';

use morphos\Russian\GeographicalNamesInflection;

class GeographicalNamesInflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider wordsProvider
     */
    public function testInflection($word, $inflected)
    {
        $this->assertEquals($inflected, array_values(GeographicalNamesInflection::getCases($word)));
    }

    public function wordsProvider()
    {
        return array(
            array('москва', array('Москва', 'Москвы', 'Москве', 'Москву', 'Москвой', 'о Москве')),
            array('Киев', array('Киев', 'Киева', 'Киеву', 'Киев', 'Киевом', 'о Киеве')),
            array('США', array('США', 'США', 'США', 'США', 'США', 'о США')),
            array('Санкт-Петербург', array('Санкт-Петербург', 'Санкт-Петербурга', 'Санкт-Петербургу', 'Санкт-Петербург', 'Санкт-Петербургом', 'о Санкт-Петербурге')),
            array('Ишимбай', array('Ишимбай', 'Ишимбая', 'Ишимбаю', 'Ишимбай', 'Ишимбаем', 'об Ишимбае')),
            array('Африка', array('Африка', 'Африки', 'Африке', 'Африку', 'Африкой', 'об Африке')),
            array('Уругвай', array('Уругвай', 'Уругвая', 'Уругваю', 'Уругвай', 'Уругваем', 'об Уругвае')),
            array('Европа', array('Европа', 'Европы', 'Европе', 'Европу', 'Европой', 'о Европе')),
            array('Азия', array('Азия', 'Азии', 'Азии', 'Азию', 'Азией', 'об Азии')),
            array('Рига', array('Рига', 'Риги', 'Риге', 'Ригу', 'Ригой', 'о Риге')),
            array('Волга', array('Волга', 'Волги', 'Волге', 'Волгу', 'Волгой', 'о Волге')),
            array('Нижний Новгород', array('Нижний Новгород', 'Нижнего Новгорода', 'Нижнему Новгороду', 'Нижний Новгород', 'Нижним Новгородом', 'о Нижнем Новгороде')),
            array('Ставрополь', array('Ставрополь', 'Ставрополя', 'Ставрополю', 'Ставрополь', 'Ставрополем', 'о Ставрополе')),
            array('Тверь', array('Тверь', 'Твери', 'Твери', 'Тверь', 'Тверью', 'о Твери')),
            array('Ессентуки', array('Ессентуки', 'Ессентуков', 'Ессентукам', 'Ессентуки', 'Ессентуками', 'о Ессентуках')),
            array('Пермь', array('Пермь', 'Перми', 'Перми', 'Пермь', 'Пермью', 'о Перми')),
            array('Рязань', array('Рязань', 'Рязани', 'Рязани', 'Рязань', 'Рязанью', 'о Рязани')),
            array('Осташков', array('Осташков', 'Осташкова', 'Осташкову', 'Осташков', 'Осташковым', 'об Осташкове'))
        );
    }

    /**
     * @dataProvider immutableWordsProvider
     */
    public function testImmutableWords($word)
    {
        $this->assertFalse(GeographicalNamesInflection::isMutable($word));
    }

    public function immutableWordsProvider()
    {
        return array(
            array('сша'),
            array('оаэ'),
        );
    }
}
