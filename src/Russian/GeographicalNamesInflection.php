<?php

namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from: https://ru.wikipedia.org/wiki/%D0%A1%D0%BA%D0%BB%D0%BE%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5_%D0%B3%D0%B5%D0%BE%D0%B3%D1%80%D0%B0%D1%84%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D1%85_%D0%BD%D0%B0%D0%B7%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9_%D0%B2_%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%BE%D0%BC_%D1%8F%D0%B7%D1%8B%D0%BA%D0%B5
 */
class GeographicalNamesInflection extends \morphos\BaseInflection implements Cases
{
    /** @var bool Настройка склоняемости славянских топонимов на -ов(о), -ев(о), -ин(о), -ын(о) */
    public static $inflectSlavicNames = true;

    /** @var string[] */
    protected static $abbreviations = [
        'сша',
        'оаэ',
        'ссср',
        'юар',
    ];

    /** @var string[] */
    protected static $delimiters = [
        ' ',
        '-на-',
        '-эль-',
        '-де-',
        '-сюр-',
        '-ан-',
        '-ла-',
        '-',
    ];

    /** @var string[] */
    protected static $ovAbnormalExceptions = [
        'осташков',
    ];

    /**
     * @var string[] Immutable names or name parts
     */
    protected static $immutableNames = [
        'алматы',
        'сочи',
        'гоа',
        'домодедово',
        'внуково',
        'шереметьево',
        'остафьево',
        'пулково',

        // фикс для Марий Эл
        'марий',
        'эл',

        // части
        'алма',
        'буда',
        'йошкар',
        'кабардино',
        'карачаево',
        'рублёво',
        'санкт',
        'улан',
        'ханты',
        'орехово',
        'лосино',
        'юрьево',
        'наро',

        // Зарубежные названия
        'пунта',
        'куала',
        'рас',
        'шарм',
        'гран',
        'гранд',
        'вильфранш',
        'льорет',
        'андорра',
        'экс',
        'эс',
        'сен',
        'ла',
    ];

    /** @var string[] */
    protected static $immutableTriggerPrefixes = [
        'спас',
        'усть',
        'соль',
    ];

    /** @var string[] */
    protected static $runawayVowelsExceptions = [
        'торжо*к',
        'волоче*к',
        'орё*л',
        'египе*т',
        'лунине*ц',
        'городо*к',
        'новогрудо*к',
        'острове*ц',
        'черепове*ц',
    ];

    /**
     * @var string[]
     * @phpstan-var array<string, string>
     */
    protected static $misspellings = [
        'орел'    => 'орёл',
        'рублево' => 'рублёво',
    ];

    /**
     * Проверяет, склоняемо ли название
     * @param string $name Название
     * @return bool
     */
    public static function isMutable($name)
    {
        $name = S::lower($name);

        // // ends with 'ы' or 'и': plural form
        // if (in_array(S::slice($name, -1), array('и', 'ы')))
        //     return false;

        if (in_array($name, static::$abbreviations, true) || in_array($name, static::$immutableNames, true)) {
            return false;
        }

        if (strpos($name, ' ') !== false) {
            // explode() is not applicable because Geographical unit may have few words
            $first_part = S::slice($name, 0, S::findFirstPosition($name, ' '));
            $last_part  = S::slice($name,
                S::findLastPosition($name, ' ') + 1);

            // город N, село N, хутор N, район N, поселок N, округ N, республика N, деревня N
            // N область, N край, N район, N волость
            if (in_array($first_part, ['город', 'село', 'хутор', 'район', 'поселок', 'округ', 'республика', 'деревня'], true)
                || in_array($last_part, ['край', 'область', 'район', 'волость'], true)) {
                return true;
            }

            // пгт N
            if ($first_part === 'пгт') {
                return false;
            }
        }

        if (strpos($name, '-') !== false && S::stringContains($name, static::$immutableTriggerPrefixes)) {
            return false;
        }

        // ends with 'е' or 'о', but not with 'ово/ёво/ево/ино/ыно'
        if (in_array(S::slice($name, -1), ['е', 'о'], true)
            && !in_array(S::slice($name, -3, -1), ['ов', 'ёв', 'ев', 'ин', 'ын'], true)) {
            return (bool)static::$inflectSlavicNames;
        }
        return true;
    }

    /**
     * Получение одной формы (падежа) названия.
     * @param string $name Название
     * @param string $case Падеж. Одна из констант {@see \morphos\Russian\Cases} или {@see \morphos\Cases}.
     * @return string
     * @throws \Exception
     * @see \morphos\Russian\Cases
     */
    public static function getCase($name, $case)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($name);
        return $forms[$case];
    }

    /**
     * Получение всех форм названия
     * @param string $name
     * @return string[]
     * @phpstan-return array<string, string>
     * @throws \Exception
     */
    public static function getCases($name)
    {
        $name = S::lower($name);

        // Проверка на неизменяемость
        if (in_array($name, static::$immutableNames, true)
            || (strpos($name, '-') !== false && S::stringContains($name, static::$immutableTriggerPrefixes))
        ) {
            return array_fill_keys(
                [
                    static::IMENIT,
                    static::RODIT,
                    static::DAT,
                    static::VINIT,
                    static::TVORIT,
                    static::PREDLOJ,
                    static::LOCATIVE,
                ]
                , S::name($name));
        }

        // Проверка на сложное название
        if (strpos($name, ' ') !== false) {
            $first_part = S::slice($name, 0, S::findFirstPosition($name, ' '));
            // город N, село N, хутор N, пгт N
            // @todo вынести список префиксов, чтобы переиспользовать
            if (in_array($first_part, ['город', 'село', 'хутор', 'пгт', 'район', 'поселок', 'округ', 'республика', 'деревня'],
                true)) {
                if ($first_part === 'пгт') {
                    return array_fill_keys(
                        [
                            static::IMENIT,
                            static::RODIT,
                            static::DAT,
                            static::VINIT,
                            static::TVORIT,
                            static::PREDLOJ,
                            static::LOCATIVE,
                        ],
                        'пгт ' . S::name(S::slice($name, 4)));
                }

                if ($first_part === 'республика') {
                    $prefix = array_map(['\\morphos\\S', 'name'], NounDeclension::getCases($first_part));
                } else {
                    $prefix = NounDeclension::getCases($first_part);
                }
                $prefix[Cases::LOCATIVE] = $prefix[Cases::PREDLOJ];

                return RussianCasesHelper::composeCasesFromWords([
                    $prefix,
                    array_fill_keys(
                        array_merge(RussianCasesHelper::getAllCases(), [\morphos\Russian\Cases::LOCATIVE]),
                        S::name(S::slice($name, S::length($first_part) + 1))),
                ]);
            }

            $last_part = S::slice($name,
                S::findLastPosition($name, ' ') + 1);
            // N область, N край
            if (in_array($last_part, ['край', 'область', 'район', 'волость'], true)) {
                $last_part_cases                  = NounDeclension::getCases($last_part);
                $last_part_cases[Cases::LOCATIVE] = $last_part_cases[Cases::PREDLOJ];
                return RussianCasesHelper::composeCasesFromWords(
                    [
                        static::getCases(S::slice($name, 0, S::findLastPosition($name, ' '))),
                        $last_part_cases,
                    ]);
            }
        }

        // Сложное название с разделителем
        foreach (static::$delimiters as $delimiter) {
            if (strpos($name, $delimiter) !== false) {
                $parts  = explode($delimiter, $name);
                $result = [];
                foreach ($parts as $i => $part) {
                    $result[$i] = static::getCases($part);
                }
                return RussianCasesHelper::composeCasesFromWords($result, $delimiter);
            }
        }

        // Исправление ошибок
        if (array_key_exists($name, static::$misspellings)) {
            $name = static::$misspellings[$name];
        }

        // Само склонение
        if (!in_array($name, static::$abbreviations, true)) {
            switch (S::slice($name, -2)) {
                // Нижний, Русский
                case 'ий':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT   => $prefix . 'ий',
                        static::RODIT    => $prefix . (RussianLanguage::isVelarConsonant(S::slice($name, -3,
                                -2)) ? 'ого' : 'его'),
                        static::DAT      => $prefix . (RussianLanguage::isVelarConsonant(S::slice($name, -3,
                                -2)) ? 'ому' : 'ему'),
                        static::VINIT    => $prefix . 'ий',
                        static::TVORIT   => $prefix . 'им',
                        static::PREDLOJ  => $prefix . (RussianLanguage::chooseEndingBySonority($prefix, 'ем', 'ом')),
                        static::LOCATIVE => $prefix . (RussianLanguage::chooseEndingBySonority($prefix, 'ем', 'ом')),
                    ];

                // Ростовская
                case 'ая':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT   => $prefix . 'ая',
                        static::RODIT    => $prefix . 'ой',
                        static::DAT      => $prefix . 'ой',
                        static::VINIT    => $prefix . 'ую',
                        static::TVORIT   => $prefix . 'ой',
                        static::PREDLOJ  => $prefix . 'ой',
                        static::LOCATIVE => $prefix . 'ой',
                    ];

                // Нижняя, Верхняя, Средняя
                case 'яя':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT   => $prefix . 'яя',
                        static::RODIT    => $prefix . 'ей',
                        static::DAT      => $prefix . 'ей',
                        static::VINIT    => $prefix . 'юю',
                        static::TVORIT   => $prefix . 'ей',
                        static::PREDLOJ  => $prefix . 'ей',
                        static::LOCATIVE => $prefix . 'ей',
                    ];

                // Россошь
                case 'шь':
                    // Пермь, Кемь
                case 'мь':
                    // Рязань, Назрань
                case 'нь':
                    // Сысерть
                case 'ть':
                    // Керчь
                case 'чь':
                    // Беларусь
                case 'сь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'ь',
                        static::RODIT    => $prefix . 'и',
                        static::DAT      => $prefix . 'и',
                        static::VINIT    => $prefix . 'ь',
                        static::TVORIT   => $prefix . 'ью',
                        static::PREDLOJ  => $prefix . 'и',
                        static::LOCATIVE => $prefix . 'и',
                    ];

                // Грозный, Благодарный
                case 'ый':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT   => $prefix . 'ый',
                        static::RODIT    => $prefix . 'ого',
                        static::DAT      => $prefix . 'ому',
                        static::VINIT    => $prefix . 'ый',
                        static::TVORIT   => $prefix . 'ым',
                        static::PREDLOJ  => $prefix . 'ом',
                        static::LOCATIVE => $prefix . 'ом',
                    ];

                // Ставрополь, Ярославль, Электросталь
                case 'ль':
                    $prefix = S::name(S::slice($name, 0, -1));

                    if ($name === 'электросталь') {
                        return [
                            static::IMENIT   => $prefix . 'ь',
                            static::RODIT    => $prefix . 'и',
                            static::DAT      => $prefix . 'и',
                            static::VINIT    => $prefix . 'ь',
                            static::TVORIT   => $prefix . 'ью',
                            static::PREDLOJ  => $prefix . 'и',
                            static::LOCATIVE => $prefix . 'и',
                        ];
                    }

                    return [
                        static::IMENIT   => $prefix . 'ь',
                        static::RODIT    => $prefix . 'я',
                        static::DAT      => $prefix . 'ю',
                        static::VINIT    => $prefix . 'ь',
                        static::TVORIT   => $prefix . 'ем',
                        static::PREDLOJ  => $prefix . 'е',
                        static::LOCATIVE => $prefix . 'е',
                    ];

                // Адыгея, Чечня
                case 'ея':
                case 'ня':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => S::name($name),
                        static::RODIT    => $prefix . 'е',
                        static::DAT      => $prefix . 'е',
                        static::VINIT    => $prefix . 'я',
                        static::TVORIT   => $prefix . 'ей',
                        static::PREDLOJ  => $prefix . 'е',
                        static::LOCATIVE => $prefix . 'е',
                    ];

                // Тверь, Анадырь
                case 'рь':
                    $prefix     = S::name(S::slice($name, 0, -1));
                    $last_vowel = S::slice($prefix, -2, -1);
                    return [
                        static::IMENIT   => $prefix . 'ь',
                        static::RODIT    => $prefix . (RussianLanguage::isBinaryVowel($last_vowel) ? 'и' : 'я'),
                        static::DAT      => $prefix . (RussianLanguage::isBinaryVowel($last_vowel) ? 'и' : 'ю'),
                        static::VINIT    => $prefix . 'ь',
                        static::TVORIT   => $prefix . (RussianLanguage::isBinaryVowel($last_vowel) ? 'ью' : 'ем'),
                        static::PREDLOJ  => $prefix . (RussianLanguage::isBinaryVowel($last_vowel) ? 'и' : 'е'),
                        static::LOCATIVE => $prefix . (RussianLanguage::isBinaryVowel($last_vowel) ? 'и' : 'е'),
                    ];

                    // Березники, Ессентуки, Химки
                case 'ки':
                        // Старые Дороги
                case 'ги':
                    // Ушачи, Ивацевичи
                case 'чи':
                    // Мытищи
                case 'щи':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'и',
                        static::RODIT    => ($name === 'луки'
                            ? $prefix
                            : (S::slice($name, -2) === 'чи'
                                ? $prefix . 'ей'
                                : $prefix . 'ов')),
                        static::DAT      => $prefix . 'ам',
                        static::VINIT    => $prefix . 'и',
                        static::TVORIT   => $prefix . 'ами',
                        static::PREDLOJ  => $prefix . 'ах',
                        static::LOCATIVE => $prefix . 'ах',
                    ];

                // Набережные
                case 'ые':
                    // Великие
                case 'ие':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'е',
                        static::RODIT    => $prefix . 'х',
                        static::DAT      => $prefix . 'м',
                        static::VINIT    => $prefix . 'е',
                        static::TVORIT   => $prefix . 'ми',
                        static::PREDLOJ  => $prefix . 'х',
                        static::LOCATIVE => $prefix . 'х',
                    ];

                // Челны
                case 'ны':
                    // Мосты
                case 'ты':
                    // Столбцы
                case 'цы':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'ы',
                        static::RODIT    => $prefix . 'ов',
                        static::DAT      => $prefix . 'ам',
                        static::VINIT    => $prefix . 'ы',
                        static::TVORIT   => $prefix . 'ами',
                        static::PREDLOJ  => $prefix . 'ах',
                        static::LOCATIVE => $prefix . 'ах',
                    ];

                // Глубокое
                case 'ое':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT   => $prefix . 'ое',
                        static::RODIT    => $prefix . 'ого',
                        static::DAT      => $prefix . 'ому',
                        static::VINIT    => $prefix . 'ое',
                        static::TVORIT   => $prefix . 'им',
                        static::PREDLOJ  => $prefix . 'ом',
                        static::LOCATIVE => $prefix . 'ом',
                    ];
            }

            switch (S::slice($name, -1)) {
                case 'р':
                    // Бор
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'р',
                        static::RODIT    => $prefix . 'ра',
                        static::DAT      => $prefix . 'ру',
                        static::VINIT    => $prefix . 'р',
                        static::TVORIT   => $prefix . 'ром',
                        static::PREDLOJ  => $prefix . 'ре',
                        static::LOCATIVE => $prefix . ($name === 'бор' ? 'ру' : 'ре'),
                    ];

                case 'ы':
                    // Чебоксары, Шахты
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'ы',
                        static::RODIT    => $prefix,
                        static::DAT      => $prefix . 'ам',
                        static::VINIT    => $prefix . 'ы',
                        static::TVORIT   => $prefix . 'ами',
                        static::PREDLOJ  => $prefix . 'ах',
                        static::LOCATIVE => $prefix . 'ах',
                    ];

                case 'я':
                    // Азия
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => S::name($name),
                        static::RODIT    => $prefix . 'и',
                        static::DAT      => $prefix . 'и',
                        static::VINIT    => $prefix . 'ю',
                        static::TVORIT   => $prefix . 'ей',
                        static::PREDLOJ  => $prefix . 'и',
                        static::LOCATIVE => $prefix . 'и',
                    ];

                case 'а':
                    // Москва, Рига
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'а',
                        static::RODIT    => $prefix . (RussianLanguage::isVelarConsonant(S::slice($name, -2,
                                -1)) || RussianLanguage::isHissingConsonant(S::slice($name, -2, -1)) ? 'и' : 'ы'),
                        static::DAT      => $prefix . 'е',
                        static::VINIT    => $prefix . 'у',
                        static::TVORIT   => $prefix . 'ой',
                        static::PREDLOJ  => $prefix . 'е',
                        static::LOCATIVE => $prefix . 'е',
                    ];

                case 'й':
                    // Ишимбай
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT   => $prefix . 'й',
                        static::RODIT    => $prefix . 'я',
                        static::DAT      => $prefix . 'ю',
                        static::VINIT    => $prefix . 'й',
                        static::TVORIT   => $prefix . 'ем',
                        static::PREDLOJ  => $prefix . 'е',
                        static::LOCATIVE => $prefix . 'е',
                    ];
            }

            if (RussianLanguage::isConsonant($last_char = S::slice($name, -1)) && !in_array($name,
                    static::$ovAbnormalExceptions, true)) {
                $runaway_vowels_list = static::getRunAwayVowelsList();

                // if run-away vowel in name
                if (isset($runaway_vowels_list[$name])) {
                    $runaway_vowel_offset = $runaway_vowels_list[$name];
                    $prefix               = S::name(S::slice($name, 0, $runaway_vowel_offset) . S::slice($name,
                            $runaway_vowel_offset + 1));
                } else {
                    $prefix = S::name($name);
                }

                // Париж, Валаам, Киев
                return [
                    static::IMENIT   => S::name($name),
                    static::RODIT    => $prefix . 'а',
                    static::DAT      => $prefix . 'у',
                    static::VINIT    => S::name($name),
                    static::TVORIT   => $prefix . (
                        RussianLanguage::isVelarConsonant(S::slice($name, -2, -1))
                        || RussianLanguage::isHissingConsonant($last_char)
                            ? 'ем' : 'ом'),
                    static::PREDLOJ  => $prefix . 'е',
                    static::LOCATIVE => $prefix . ($name === 'крым' ? 'у' : 'е'),
                ];
            }

            // ов, ово, ёв, ёво, ев, ево, ...
            $suffixes = ['ов', 'ёв', 'ев', 'ин', 'ын'];
            if (static::$inflectSlavicNames && (
                    (in_array(S::slice($name, -1), ['е', 'о'], true) && in_array(S::slice($name, -3, -1), $suffixes,
                            true))
                    || in_array(S::slice($name, -2), $suffixes, true)
                )) {
                // ово, ёво, ...
                if (in_array(S::slice($name, -3, -1), $suffixes, true)) {
                    $prefix = S::name(S::slice($name, 0, -1));
                } // ов, её, ...
                elseif (in_array(S::slice($name, -2), $suffixes, true)) {
                    $prefix = S::name($name);
                } else {
                    $prefix = '';
                }

                return [
                    static::IMENIT   => S::name($name),
                    static::RODIT    => $prefix . 'а',
                    static::DAT      => $prefix . 'у',
                    static::VINIT    => S::name($name),
                    static::TVORIT   => $name !== 'осташков' ? $prefix . 'ом' : $prefix . 'ым',
                    static::PREDLOJ  => $prefix . 'е',
                    static::LOCATIVE => $prefix . 'е',
                ];
            }
        }

        // if no rules matches or name is immutable
        $name = in_array($name, static::$abbreviations, true) ? S::upper($name) : S::name($name);
        return array_fill_keys(
            [
                static::IMENIT,
                static::RODIT,
                static::DAT,
                static::VINIT,
                static::TVORIT,
                static::PREDLOJ,
                static::LOCATIVE,
            ],
            $name);
    }

    /**
     * @return int[]|false[]
     */
    protected static function getRunAwayVowelsList()
    {
        $runawayVowelsNormalized = [];
        foreach (static::$runawayVowelsExceptions as $word) {
            $runawayVowelsNormalized[str_replace('*', '', $word)] = S::indexOf($word, '*') - 1;
        }
        return $runawayVowelsNormalized;
    }
}
