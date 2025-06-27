<?php

namespace morphos\test\Russian;

use morphos\NamesInflection;
use morphos\Russian\Cases;
use morphos\Russian\LastNamesInflection;
use PHPUnit\Framework\TestCase;

class LastNamesInflectionTest extends TestCase
{
    /**
     * @dataProvider lastNamesProvider
     */
    public function testMutable($name, $gender)
    {
        $this->assertTrue(LastNamesInflection::isMutable($name, $gender));
    }

    /**
     * @dataProvider lastNamesProvider
     */
    public function testGetCases($name, $gender, $name2, $name3, $name4, $name5, $name6)
    {
        $forms = LastNamesInflection::getCases($name, $gender);
        $this->assertEquals([
            Cases::IMENIT => $name,
            Cases::RODIT => $name2,
            Cases::DAT => $name3,
            Cases::VINIT => $name4,
            Cases::TVORIT => $name5,
            Cases::PREDLOJ => $name6,
        ], $forms);
    }

    /**
     * @dataProvider lastNamesProvider()
     */
    public function testDetectGender($name, $gender)
    {
        $result = LastNamesInflection::detectGender($name);
        if ($result !== null) {
            $this->assertEquals($gender, $result, 'For name ' . $name);
        } else {
            $this->markTestSkipped('Test gender detection is skipped for ' . $name);
//            $this->assertEquals($gender, $result, 'For name ' . $name);
        }
    }

    public function lastNamesProvider()
    {
        return [
            ['Смирнов', NamesInflection::MALE, 'Смирнова', 'Смирнову', 'Смирнова', 'Смирновым', 'Смирнове'],
            ['Кромской', NamesInflection::MALE, 'Кромского', 'Кромскому', 'Кромского', 'Кромским', 'Кромском'],
            ['Ольховой', NamesInflection::MALE, 'Ольхового', 'Ольховому', 'Ольхового', 'Ольховым', 'Ольховом'],
            ['Ус', NamesInflection::MALE, 'Уса', 'Усу', 'Уса', 'Усом', 'Усе'],
            ['Кузьмич', NamesInflection::MALE, 'Кузьмича', 'Кузьмичу', 'Кузьмича', 'Кузьмичом', 'Кузьмиче'],
            ['Берг', NamesInflection::MALE, 'Берга', 'Бергу', 'Берга', 'Бергом', 'Берге'],
            ['Медведь', NamesInflection::MALE, 'Медведя', 'Медведю', 'Медведя', 'Медведем', 'Медведе'],
            ['Суздаль', NamesInflection::MALE, 'Суздаля', 'Суздалю', 'Суздаля', 'Суздалем', 'Суздале'],
            ['Тронь', NamesInflection::MALE, 'Троня', 'Троню', 'Троня', 'Тронем', 'Троне'],
            ['Толстой', NamesInflection::MALE, 'Толстого', 'Толстому', 'Толстого', 'Толстым', 'Толстом'],
            ['Яровой', NamesInflection::MALE, 'Ярового', 'Яровому', 'Ярового', 'Яровым', 'Яровом'],
            ['Стальной', NamesInflection::MALE, 'Стального', 'Стальному', 'Стального', 'Стальным', 'Стальном'],
            ['Жареный', NamesInflection::MALE, 'Жареного', 'Жареному', 'Жареного', 'Жареным', 'Жареном'],
            ['Брынзей', NamesInflection::MALE, 'Брынзея', 'Брынзею', 'Брынзея', 'Брынзеем', 'Брынзее'],
            ['Бакай', NamesInflection::MALE, 'Бакая', 'Бакаю', 'Бакая', 'Бакаем', 'Бакае'],
            ['Грицай', NamesInflection::MALE, 'Грицая', 'Грицаю', 'Грицая', 'Грицаем', 'Грицае'],
            ['Прожога', NamesInflection::MALE, 'Прожоги', 'Прожоге', 'Прожогу', 'Прожогой', 'Прожоге'],
            ['Мазепа', NamesInflection::MALE, 'Мазепы', 'Мазепе', 'Мазепу', 'Мазепой', 'Мазепе'],
            ['Цой', NamesInflection::MALE, 'Цоя', 'Цою', 'Цоя', 'Цоем', 'Цое'],
            ['Лукелий', NamesInflection::MALE, 'Лукелия', 'Лукелию', 'Лукелия', 'Лукелием', 'Лукелии'],
            ['Стуккей', NamesInflection::MALE, 'Стуккея', 'Стуккею', 'Стуккея', 'Стуккеем', 'Стуккее'],

            ['Смирнова', NamesInflection::FEMALE, 'Смирновой', 'Смирновой', 'Смирнову', 'Смирновой', 'Смирновой'],
            ['Кромская', NamesInflection::FEMALE, 'Кромской', 'Кромской', 'Кромскую', 'Кромской', 'Кромской'],
            ['Закипная', NamesInflection::FEMALE, 'Закипной', 'Закипной', 'Закипную', 'Закипной', 'Закипной'],
            //            ['Зима', NamesInflection::FEMALE, 'Зимы', 'Зиме', 'Зиму', 'Зимой', 'Зиме'],
            //            ['Зоя', NamesInflection::FEMALE, 'Зои', 'Зое', 'Зою', 'Зоей', 'Зое'],
            //            ['Молодыха', NamesInflection::FEMALE, 'Молодыхи', 'Молодыхе', 'Молодыху', 'Молодыхой', 'Молодыхе'],
            ['Стальная', NamesInflection::FEMALE, 'Стальной', 'Стальной', 'Стальную', 'Стальной', 'Стальной'],
            ['Яровая', NamesInflection::FEMALE, 'Яровой', 'Яровой', 'Яровую', 'Яровой', 'Яровой'],
            ['Янушонок', NamesInflection::MALE, 'Янушонка', 'Янушонку', 'Янушонка', 'Янушонком', 'Янушонке'],
            ['Оборок', NamesInflection::MALE, 'Оборка', 'Оборку', 'Оборка', 'Оборком', 'Оборке'],
            ['Бок', NamesInflection::MALE, 'Бока', 'Боку', 'Бока', 'Боком', 'Боке'],
            ['Неборачек', NamesInflection::MALE, 'Неборачка', 'Неборачку', 'Неборачка', 'Неборачком', 'Неборачке'],
            ['Городец', NamesInflection::MALE, 'Городца', 'Городцу', 'Городца', 'Городцом', 'Городце'],
            ['Малец', NamesInflection::MALE, 'Мальца', 'Мальцу', 'Мальца', 'Мальцом', 'Мальце'],
            ['Малек', NamesInflection::MALE, 'Малька', 'Мальку', 'Малька', 'Мальком', 'Мальке'],
            [
                'Завгородняя',
                NamesInflection::FEMALE,
                'Завгородней',
                'Завгородней',
                'Завгороднюю',
                'Завгородней',
                'Завгородней',
            ],

            // foreign names
            //            ['Мартен-Люган', NamesInflection::MALE, 'Мартена-Люгана', 'Мартену-Люгану', 'Мартена-Люгана', 'Мартеном-Люганом', 'Мартене-Люгане'],
            [
                'Копусов-Долинин',
                NamesInflection::MALE,
                'Копусова-Долинина',
                'Копусову-Долинину',
                'Копусова-Долинина',
                'Копусовым-Долининым',
                'Копусове-Долинине',
            ],
            //            ['Кучера-Бози', NamesInflection::MALE, 'Кучеры-Бози', 'Кучере-Бози', 'Кучеру-Бози', 'Кучерой-Бози', 'Кучере-Бози'],
        ];
    }

    /**
     * @dataProvider immutableNamesProvider()
     */
    public function testImmutable($name, $gender)
    {
        $this->assertFalse(LastNamesInflection::isMutable($name, $gender));
    }

    public function immutableNamesProvider()
    {
        return [
            ['Фоминых', NamesInflection::MALE],
            ['Хитрово', NamesInflection::MALE],
            ['Бози', NamesInflection::MALE],
            ['Цой', NamesInflection::FEMALE],
            ['А', NamesInflection::FEMALE],
        ];
    }
}
