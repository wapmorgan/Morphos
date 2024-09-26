<?php

namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from: http://www.imena.org/decl_mn.html / http://www.imena.org/decl_fn.html
 * and http://rus.omgpu.ru/2016/04/18/%D1%81%D0%BA%D0%BB%D0%BE%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5-%D0%BB%D0%B8%D1%87%D0%BD%D1%8B%D1%85-%D0%B8%D0%BC%D1%91%D0%BD/
 */
class FirstNamesInflection extends \morphos\NamesInflection implements Cases
{
    /**
     * @var string[][]
     * @phpstan-var array<string, array<string, string>>
     */
    protected static $exceptions = [
        'лев'   => [
            self::IMENIT  => 'Лев',
            self::RODIT   => 'Льва',
            self::DAT     => 'Льву',
            self::VINIT   => 'Льва',
            self::TVORIT  => 'Львом',
            self::PREDLOJ => 'Льве',
        ],
        'павел' => [
            self::IMENIT  => 'Павел',
            self::RODIT   => 'Павла',
            self::DAT     => 'Павлу',
            self::VINIT   => 'Павла',
            self::TVORIT  => 'Павлом',
            self::PREDLOJ => 'Павле',
        ],
    ];

    /** @var string[] */
    protected static $menNames = [
        'абрам',
        'аверьян',
        'авраам',
        'агафон',
        'адам',
        'азар',
        'акакий',
        'аким',
        'аксён',
        'александр',
        'алексей',
        'альберт',
        'анатолий',
        'андрей',
        'андрон',
        'антип',
        'антон',
        'аполлон',
        'аристарх',
        'аркадий',
        'арнольд',
        'арсений',
        'арсентий',
        'артем',
        'артём',
        'артемий',
        'артур',
        'аскольд',
        'афанасий',
        'богдан',
        'борис',
        'борислав',
        'бронислав',
        'вадим',
        'валентин',
        'валерий',
        'варлам',
        'василий',
        'венедикт',
        'вениамин',
        'веньямин',
        'венцеслав',
        'виктор',
        'виген',
        'вилен',
        'виталий',
        'владилен',
        'владимир',
        'владислав',
        'владлен',
        'вова',
        'всеволод',
        'всеслав',
        'вячеслав',
        'гавриил',
        'геннадий',
        'георгий',
        'герман',
        'глеб',
        'григорий',
        'давид',
        'даниил',
        'данил',
        'данила',
        'демьян',
        'денис',
        'димитрий',
        'дмитрий',
        'добрыня',
        'евгений',
        'евдоким',
        'евсей',
        'егор',
        'емельян',
        'еремей',
        'ермолай',
        'ерофей',
        'ефим',
        'захар',
        'иван',
        'игнат',
        'игорь',
        'илларион',
        'иларион',
        'илья',
        'иосиф',
        'казимир',
        'касьян',
        'кирилл',
        'кондрат',
        'константин',
        'кузьма',
        'лавр',
        'лаврентий',
        'лазарь',
        'ларион',
        'лев',
        'леонард',
        'леонид',
        'лука',
        'максим',
        'марат',
        'мартын',
        'матвей',
        'мефодий',
        'мирон',
        'михаил',
        'моисей',
        'назар',
        'никита',
        'николай',
        'олег',
        'осип',
        'остап',
        'павел',
        'панкрат',
        'пантелей',
        'парамон',
        'пётр',
        'петр',
        'платон',
        'потап',
        'прохор',
        'роберт',
        'ростислав',
        'савва',
        'савелий',
        'семён',
        'семен',
        'сергей',
        'сидор',
        'спартак',
        'тарас',
        'терентий',
        'тимофей',
        'тимур',
        'тихон',
        'ульян',
        'фёдор',
        'федор',
        'федот',
        'феликс',
        'фирс',
        'фома',
        'харитон',
        'харлам',
        'эдуард',
        'эммануил',
        'эраст',
        'юлиан',
        'юлий',
        'юрий',
        'яков',
        'ян',
        'ярослав',
    ];

    /** @var string[] */
    protected static $womenNames = [
        'авдотья',
        'аврора',
        'агата',
        'агния',
        'агриппина',
        'ада',
        'аксинья',
        'алевтина',
        'александра',
        'алёна',
        'алена',
        'алина',
        'алиса',
        'алла',
        'альбина',
        'амалия',
        'анастасия',
        'ангелина',
        'анжела',
        'анжелика',
        'анна',
        'антонина',
        'анфиса',
        'арина',
        'белла',
        'божена',
        'валентина',
        'валерия',
        'ванда',
        'варвара',
        'василина',
        'василиса',
        'вера',
        'вероника',
        'виктория',
        'виола',
        'виолетта',
        'вита',
        'виталия',
        'владислава',
        'власта',
        'галина',
        'глафира',
        'дарья',
        'диана',
        'дина',
        'ева',
        'евгения',
        'евдокия',
        'евлампия',
        'екатерина',
        'елена',
        'елизавета',
        'ефросиния',
        'ефросинья',
        'жанна',
        'зиновия',
        'злата',
        'зоя',
        'ивонна',
        'изольда',
        'илона',
        'инга',
        'инесса',
        'инна',
        'ирина',
        'ия',
        'капитолина',
        'карина',
        'каролина',
        'кира',
        'клавдия',
        'клара',
        'клеопатра',
        'кристина',
        'ксения',
        'лада',
        'лариса',
        'лиана',
        'лидия',
        'лилия',
        'лина',
        'лия',
        'лора',
        'любава',
        'любовь',
        'людмила',
        'майя',
        'маргарита',
        'марианна',
        'мариетта',
        'марина',
        'мария',
        'марья',
        'марта',
        'марфа',
        'марьяна',
        'матрёна',
        'матрена',
        'матрона',
        'милена',
        'милослава',
        'мина',
        'мирослава',
        'муза',
        'надежда',
        'настасия',
        'настасья',
        'наталия',
        'наталья',
        'нелли',
        'ника',
        'нина',
        'нинель',
        'нонна',
        'оксана',
        'олимпиада',
        'ольга',
        'пелагея',
        'полина',
        'прасковья',
        'раиса',
        'рената',
        'римма',
        'роза',
        'роксана',
        'руфь',
        'сарра',
        'светлана',
        'серафима',
        'снежана',
        'софья',
        'софия',
        'стелла',
        'степанида',
        'стефания',
        'таисия',
        'таисья',
        'тамара',
        'татьяна',
        'ульяна',
        'устиния',
        'устинья',
        'фаина',
        'фёкла',
        'фекла',
        'феодора',
        'хаврония',
        'христина',
        'эвелина',
        'эдита',
        'элеонора',
        'элла',
        'эльвира',
        'эмилия',
        'эмма',
        'юдифь',
        'юлиана',
        'юлия',
        'ядвига',
        'яна',
        'ярослава',
    ];

    /** @var string[] */
    protected static $immutableNames = [
        'николя',
    ];

    /**
     * @param string $name
     * @param string $case
     * @param null|string $gender
     * @return string
     * @throws \Exception
     */
    public static function getCase($name, $case, $gender = null)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($name, $gender);
        return $forms[$case];
    }

    /**
     * @param string $name
     * @param null|string $gender
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($name, $gender = null)
    {
        $name = S::lower($name);

        if (static::isMutable($name, $gender)) {
            // common rules for ия and я
            if (S::slice($name, -2) == 'ия') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT  => $prefix . 'я',
                    static::RODIT   => $prefix . 'и',
                    static::DAT     => $prefix . 'и',
                    static::VINIT   => $prefix . 'ю',
                    static::TVORIT  => $prefix . 'ей',
                    static::PREDLOJ => $prefix . 'и',
                ];
            } elseif (S::slice($name, -1) == 'я') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT  => $prefix . 'я',
                    static::RODIT   => $prefix . 'и',
                    static::DAT     => $prefix . 'е',
                    static::VINIT   => $prefix . 'ю',
                    static::TVORIT  => $prefix . 'ей',
                    static::PREDLOJ => $prefix . 'е',
                ];
            }

            if (!in_array($name, static::$immutableNames, true)) {
                if ($gender === null) {
                    $gender = static::detectGender($name);
                }
                if ($gender === static::MALE || $name === 'саша') {
                    if (($result = static::getCasesMan($name)) !== null) {
                        return $result;
                    }
                } elseif ($gender === static::FEMALE) {
                    if (($result = static::getCasesWoman($name)) !== null) {
                        return $result;
                    }
                }
            }
        }

        $name = S::name($name);
        return array_fill_keys([
            static::IMENIT,
            static::RODIT,
            static::DAT,
            static::VINIT,
            static::TVORIT,
            static::PREDLOJ,
        ], $name);
    }

    /**
     * Checks if name is mutable
     * @param string $name
     * @param null|string $gender
     * @return bool
     */
    public static function isMutable($name, $gender = null)
    {
        if (S::length($name) === 1) {
            return false;
        }

        $name = S::lower($name);

        if (in_array($name, static::$immutableNames, true)) {
            return false;
        }

        if ($gender === null) {
            $gender = static::detectGender($name);
        }

        // man rules
        if ($gender === static::MALE) {
            // soft consonant
            if (S::lower(S::slice($name, -1)) == 'ь' && RussianLanguage::isConsonant(S::slice($name, -2, -1))) {
                return true;
            } elseif (in_array(S::slice($name, -1), array_diff(RussianLanguage::$consonants, ['й', /*'Ч', 'Щ'*/]),
                true)) { // hard consonant
                return true;
            } elseif (S::slice($name, -1) == 'й') {
                return true;
            } else {
                if (in_array(S::slice($name, -2), ['ло', 'ко'], true)) {
                    return true;
                }
            }
        } else {
            if ($gender === static::FEMALE) {
                // soft consonant
                if (S::lower(S::slice($name, -1)) == 'ь' && RussianLanguage::isConsonant(S::slice($name, -2, -1))) {
                    return true;
                } else {
                    if (RussianLanguage::isHissingConsonant(S::slice($name, -1))) {
                        return true;
                    }
                }
            }
        }

        // common rules
        if ((in_array(S::slice($name, -1), ['а', 'я']) && !RussianLanguage::isVowel(S::slice($name, -2,
                    -1))) || in_array(S::slice($name, -2), ['ия', 'ья', 'ея', 'оя'], true)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function detectGender($name)
    {
        $name = S::lower($name);
        if (in_array($name, static::$menNames, true)) {
            return static::MALE;
        } elseif (in_array($name, static::$womenNames, true)) {
            return static::FEMALE;
        }

        $man   = $woman = 0;
        $last1 = S::slice($name, -1);
        $last2 = S::slice($name, -2);
        $last3 = S::slice($name, -3);

        // try to detect gender by some statistical rules
        //
        if ($last1 == 'й') {
            $man += 0.9;
        }
        if ($last1 == 'ь') {
            $man += 0.02;
        }
        if (in_array($last1, RussianLanguage::$consonants, true)) {
            $man += 0.01;
        }
        if (in_array($last1, RussianLanguage::$vowels, true)) {
            $woman += 0.01;
        }
        if (in_array($last2, ['он', 'ов', 'ав', 'ам', 'ол', 'ан', 'рд', 'мп'], true)) {
            $man += 0.3;
        }
        if (in_array($last2, ['вь', 'фь', 'ль'], true)) {
            $woman += 0.1;
        }
        if (in_array($last2, ['ла'], true)) {
            $woman += 0.04;
        }
        if (in_array($last2, ['то', 'ма'], true)) {
            $man += 0.01;
        }
        if (in_array($last3, ['лья', 'вва', 'ока', 'ука', 'ита'], true)) {
            $man += 0.2;
        }
        if (in_array($last3, ['има'], true)) {
            $woman += 0.15;
        }
        if (in_array($last3, ['лия', 'ния', 'сия', 'дра', 'лла', 'кла', 'опа', 'ора'], true)) {
            $woman += 0.5;
        }
        if (in_array(S::slice($name, -4), ['льда', 'фира', 'нина', 'тина', 'лита', 'алья', 'аида'], true)) {
            $woman += 0.5;
        }

        return $man === $woman ? null
            : ($man > $woman ? static::MALE : static::FEMALE);
    }

    /**
     * @param string $name
     * @return string[]|null
     * @phpstan-return array<string, string>|null
     */
    protected static function getCasesMan($name)
    {
        // special cases for Лев, Павел
        if (isset(static::$exceptions[$name])) {
            return static::$exceptions[$name];
        } elseif (in_array(S::slice($name, -1), array_diff(RussianLanguage::$consonants, ['й', /*'Ч', 'Щ'*/]),
            true)) { // hard consonant
            if (in_array(S::slice($name, -2), ['ек', 'ёк'], true)) { // Витек, Санек
                // case for foreign names like Салмонбек and Абдыбек
                if (RussianLanguage::isConsonant(S::slice($name, -4, -3)) || S::slice($name, -4, -3) === 'ы') {
                    $prefix = S::name(S::slice($name, 0, -2)) . 'ек';
                } else {
                    $prefix = S::name(S::slice($name, 0, -2)) . 'ьк';
                }
            } else {
                if ($name === 'пётр') {
                    $prefix = S::name(str_replace('ё', 'е', $name));
                } else {
                    $prefix = S::name($name);
                }
            }
            return [
                static::IMENIT  => S::name($name),
                static::RODIT   => $prefix . 'а',
                static::DAT     => $prefix . 'у',
                static::VINIT   => $prefix . 'а',
                static::TVORIT  => RussianLanguage::isHissingConsonant(S::slice($name, -1)) || S::slice($name,
                    -1) == 'ц' ? $prefix . 'ем' : $prefix . 'ом',
                static::PREDLOJ => $prefix . 'е',
            ];
        } elseif (S::slice($name, -1) == 'ь' && RussianLanguage::isConsonant(S::slice($name, -2,
                -1))) { // soft consonant
            $prefix = S::name(S::slice($name, 0, -1));
            return [
                static::IMENIT  => $prefix . 'ь',
                static::RODIT   => $prefix . 'я',
                static::DAT     => $prefix . 'ю',
                static::VINIT   => $prefix . 'я',
                static::TVORIT  => $prefix . 'ем',
                static::PREDLOJ => $prefix . 'е',
            ];
        } elseif (in_array(S::slice($name, -2), ['ай', 'ей', 'ой', 'уй', 'яй', 'юй', 'ий'], true)) {
            $prefix  = S::name(S::slice($name, 0, -1));
            $postfix = S::slice($name, -2) == 'ий' ? 'и' : 'е';
            return [
                static::IMENIT  => $prefix . 'й',
                static::RODIT   => $prefix . 'я',
                static::DAT     => $prefix . 'ю',
                static::VINIT   => $prefix . 'я',
                static::TVORIT  => $prefix . 'ем',
                static::PREDLOJ => $prefix . $postfix,
            ];
        } elseif (S::slice($name, -1) == 'а' && RussianLanguage::isConsonant($before = S::slice($name, -2,
                -1)) && !in_array($before, [/*'г', 'к', 'х', */ 'ц'], true)) {
            $prefix  = S::name(S::slice($name, 0, -1));
            $postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, ['г', 'к', 'х'],
                    true)) ? 'и' : 'ы';
            return [
                static::IMENIT  => $prefix . 'а',
                static::RODIT   => $prefix . $postfix,
                static::DAT     => $prefix . 'е',
                static::VINIT   => $prefix . 'у',
                static::TVORIT  => $prefix . ($before === 'ш' ? 'е' : 'о') . 'й',
                static::PREDLOJ => $prefix . 'е',
            ];
        } elseif (S::slice($name, -2) == 'ло' || S::slice($name, -2) == 'ко') {
            $prefix  = S::name(S::slice($name, 0, -1));
            $postfix = S::slice($name, -2, -1) == 'к' ? 'и' : 'ы';
            return [
                static::IMENIT  => $prefix . 'о',
                static::RODIT   => $prefix . $postfix,
                static::DAT     => $prefix . 'е',
                static::VINIT   => $prefix . 'у',
                static::TVORIT  => $prefix . 'ой',
                static::PREDLOJ => $prefix . 'е',
            ];
        }

        return null;
    }

    /**
     * @param string $name
     * @return string[]|null
     * @phpstan-return array<string, string>|null
     */
    protected static function getCasesWoman($name)
    {
        if (S::slice($name, -1) == 'а' && !RussianLanguage::isVowel($before = (S::slice($name, -2, -1)))) {
            $prefix = S::name(S::slice($name, 0, -1));
            if ($before != 'ц') {
                $postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, ['г', 'к', 'х'],
                        true)) ? 'и' : 'ы';
                return [
                    static::IMENIT  => $prefix . 'а',
                    static::RODIT   => $prefix . $postfix,
                    static::DAT     => $prefix . 'е',
                    static::VINIT   => $prefix . 'у',
                    static::TVORIT  => $prefix . 'ой',
                    static::PREDLOJ => $prefix . 'е',
                ];
            } else {
                return [
                    static::IMENIT  => $prefix . 'а',
                    static::RODIT   => $prefix . 'ы',
                    static::DAT     => $prefix . 'е',
                    static::VINIT   => $prefix . 'у',
                    static::TVORIT  => $prefix . 'ей',
                    static::PREDLOJ => $prefix . 'е',
                ];
            }
        } elseif (S::slice($name, -1) == 'ь' && RussianLanguage::isConsonant(S::slice($name, -2, -1))) {
            $prefix = S::name(S::slice($name, 0, -1));
            return [
                static::IMENIT  => $prefix . 'ь',
                static::RODIT   => $prefix . 'и',
                static::DAT     => $prefix . 'и',
                static::VINIT   => $prefix . 'ь',
                static::TVORIT  => $prefix . 'ью',
                static::PREDLOJ => $prefix . 'и',
            ];
        } elseif (RussianLanguage::isHissingConsonant(S::slice($name, -1))) {
            $prefix = S::name($name);
            return [
                static::IMENIT  => $prefix,
                static::RODIT   => $prefix . 'и',
                static::DAT     => $prefix . 'и',
                static::VINIT   => $prefix,
                static::TVORIT  => $prefix . 'ью',
                static::PREDLOJ => $prefix . 'и',
            ];
        }
        return null;
    }
}
