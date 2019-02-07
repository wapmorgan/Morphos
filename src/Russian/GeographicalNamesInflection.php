<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from: https://ru.wikipedia.org/wiki/%D0%A1%D0%BA%D0%BB%D0%BE%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5_%D0%B3%D0%B5%D0%BE%D0%B3%D1%80%D0%B0%D1%84%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D1%85_%D0%BD%D0%B0%D0%B7%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9_%D0%B2_%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%BE%D0%BC_%D1%8F%D0%B7%D1%8B%D0%BA%D0%B5
 */
class GeographicalNamesInflection extends \morphos\BaseInflection implements Cases
{
    use RussianLanguage, CasesHelper;

    protected static $abbreviations = [
        'сша',
        'оаэ',
        'ссср',
        'юар',
    ];

    protected static $delimiters = [
        ' ',
        '-на-',
        '-',
    ];

    protected static $ovAbnormalExceptions = [
        'осташков',
    ];

    protected static $immutableParts = [
        'санкт',
        'йошкар',
        'улан',
    ];

    protected static $runawayVowelsExceptions = [
        'торжо*к',
        'волоче*к',
        'орё*л',
    ];

    protected static $misspellings = [
        'орел' => 'орёл',
    ];

    /**
     * @return array|bool
     */
    protected static function getRunAwayVowelsList()
    {
        $runawayVowelsNormalized = [];
        foreach (static::$runawayVowelsExceptions as $word) {
            $runawayVowelsNormalized[str_replace('*', null, $word)] = S::indexOf($word, '*') - 1;
        }
        return $runawayVowelsNormalized;
    }

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

        if (in_array($name, static::$abbreviations, true) || in_array($name, static::$immutableParts, true)) {
            return false;
        }

        if (strpos($name, ' ') !== false) {
            // explode() is not applicable because Geographical unit may have few words
            $first_part = S::slice($name, 0, S::findFirstPosition($name, ' '));
            $last_part = S::slice($name,
                S::findLastPosition($name, ' ') + 1);

            // город N, село N, хутор N, район N, поселок N, округ N, республика N
            // N область, N край
            if (in_array($first_part, ['город', 'село', 'хутор', 'район', 'поселок', 'округ', 'республика'], true)
                || in_array($last_part, ['край', 'область'], true)) {
                return true;
            }

            // пгт N
            if ($first_part === 'пгт')
                return false;
        }

        // ends with 'е' or 'о', but not with 'ово/ёво/ево/ино/ыно'
        if (in_array(S::slice($name, -1), ['е', 'о'], true) && !in_array(S::slice($name, -3, -1), ['ов', 'ёв', 'ев', 'ин', 'ын'], true)) {
            return false;
        }
        return true;
    }

    /**
     * Получение всех форм названия
     * @param string $name
     * @return array
     * @throws \Exception
     */
    public static function getCases($name)
    {
        $name = S::lower($name);

        // Проверка на неизменяемость и сложное название
        if (in_array($name, static::$immutableParts, true)) {
            return array_fill_keys([static::IMENIT, static::RODIT, static::DAT, static::VINIT, static::TVORIT, static::PREDLOJ], S::name($name));
        }

        if (strpos($name, ' ') !== false) {
            $first_part = S::slice($name, 0, S::findFirstPosition($name, ' '));
            // город N, село N, хутор N, пгт N
            if (in_array($first_part, ['город', 'село', 'хутор', 'пгт', 'район', 'поселок', 'округ', 'республика'], true)) {
                if ($first_part !== 'пгт')
                    return static::composeCasesFromWords([
                        $first_part !== 'республика'
                            ? NounDeclension::getCases($first_part)
                            : array_map(['\\morphos\\S', 'name'], NounDeclension::getCases($first_part)),
                        array_fill_keys(static::getAllCases(), S::name(S::slice($name, S::length($first_part) + 1)))
                    ]);
                else
                    return array_fill_keys([static::IMENIT, static::RODIT, static::DAT, static::VINIT, static::TVORIT, static::PREDLOJ], 'пгт '.S::name(S::slice($name, 4)));
            }

            $last_part = S::slice($name,
                S::findLastPosition($name, ' ') + 1);
            // N область, N край
            if (in_array($last_part, ['край', 'область'], true)) {
                return static::composeCasesFromWords([static::getCases(S::slice($name, 0, S::findLastPosition($name, ' '))), NounDeclension::getCases($last_part)]);
            }
        }

        // Сложное название через пробел, '-' или '-на-'
        foreach (static::$delimiters as $delimiter) {
            if (strpos($name, $delimiter) !== false) {
                $parts = explode($delimiter, $name);
                $result = [];
                foreach ($parts as $i => $part) {
                    $result[$i] = static::getCases($part);
                }
                return static::composeCasesFromWords($result, $delimiter);
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
                        static::IMENIT => $prefix.'ий',
                        static::RODIT => $prefix.(static::isVelarConsonant(S::slice($name, -3, -2)) ? 'ого' : 'его'),
                        static::DAT => $prefix.(static::isVelarConsonant(S::slice($name, -3, -2)) ? 'ому' : 'ему'),
                        static::VINIT => $prefix.'ий',
                        static::TVORIT => $prefix.'им',
                        static::PREDLOJ => $prefix.(static::chooseEndingBySonority($prefix, 'ем', 'ом')),
                    ];

                // Ростовская
                case 'ая':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT => $prefix.'ая',
                        static::RODIT => $prefix.'ой',
                        static::DAT => $prefix.'ой',
                        static::VINIT => $prefix.'ую',
                        static::TVORIT => $prefix.'ой',
                        static::PREDLOJ => $prefix.'ой',
                    ];

                // Россошь
                case 'шь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix.'ь',
                        static::RODIT => $prefix.'и',
                        static::DAT => $prefix.'и',
                        static::VINIT => $prefix.'ь',
                        static::TVORIT => $prefix.'ью',
                        static::PREDLOJ => $prefix.'и',
                    ];

                // Грозный, Благодарный
                case 'ый':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT => $prefix.'ый',
                        static::RODIT => $prefix.'ого',
                        static::DAT => $prefix.'ому',
                        static::VINIT => $prefix.'ый',
                        static::TVORIT => $prefix.'ым',
                        static::PREDLOJ => $prefix.'ом',
                    ];

                // Ставрополь, Ярославль, Электросталь
                case 'ль':
                    $prefix = S::name(S::slice($name, 0, -1));

                    if ($name === 'электросталь')
                        return [
                            static::IMENIT => $prefix.'ь',
                            static::RODIT => $prefix.'и',
                            static::DAT => $prefix.'и',
                            static::VINIT => $prefix.'ь',
                            static::TVORIT => $prefix.'ью',
                            static::PREDLOJ => $prefix.'и',
                        ];

                    return [
                        static::IMENIT => $prefix.'ь',
                        static::RODIT => $prefix.'я',
                        static::DAT => $prefix.'ю',
                        static::VINIT => $prefix.'ь',
                        static::TVORIT => $prefix.'ем',
                        static::PREDLOJ => $prefix.'е',
                    ];

                // Тверь, Анадырь
                case 'рь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    $last_vowel = S::slice($prefix, -2, -1);
                    return [
                        static::IMENIT => $prefix . 'ь',
                        static::RODIT => $prefix . (static::isBinaryVowel($last_vowel) ? 'и' : 'я'),
                        static::DAT => $prefix . (static::isBinaryVowel($last_vowel) ? 'и' : 'ю'),
                        static::VINIT => $prefix . 'ь',
                        static::TVORIT => $prefix . (static::isBinaryVowel($last_vowel) ? 'ью' : 'ем'),
                        static::PREDLOJ => $prefix . (static::isBinaryVowel($last_vowel) ? 'и' : 'е'),
                    ];

                // Березники, Ессентуки
                case 'ки':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix . 'и',
                        static::RODIT => $name == 'луки' ? $prefix : $prefix . 'ов',
                        static::DAT => $prefix . 'ам',
                        static::VINIT => $prefix . 'и',
                        static::TVORIT => $prefix . 'ами',
                        static::PREDLOJ => $prefix . 'ах',
                    ];

                // Пермь, Кемь
                case 'мь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix . 'ь',
                        static::RODIT => $prefix . 'и',
                        static::DAT => $prefix . 'и',
                        static::VINIT => $prefix . 'ь',
                        static::TVORIT => $prefix . 'ью',
                        static::PREDLOJ => $prefix . 'и',
                    ];

                // Рязань, Назрань
                case 'нь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix . 'ь',
                        static::RODIT => $prefix . 'и',
                        static::DAT => $prefix . 'и',
                        static::VINIT => $prefix . 'ь',
                        static::TVORIT => $prefix . 'ью',
                        static::PREDLOJ => $prefix . 'и',
                    ];

                // Набережные
                case 'ые':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix . 'е',
                        static::RODIT => $prefix . 'х',
                        static::DAT => $prefix . 'м',
                        static::VINIT => $prefix . 'е',
                        static::TVORIT => $prefix . 'ми',
                        static::PREDLOJ => $prefix . 'х',
                    ];

                // Челны
                case 'ны':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix . 'ы',
                        static::RODIT => $prefix . 'ов',
                        static::DAT => $prefix . 'ам',
                        static::VINIT => $prefix . 'ы',
                        static::TVORIT => $prefix . 'ами',
                        static::PREDLOJ => $prefix . 'ах',
                    ];

                // Великие
                case 'ие':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix.'е',
                        static::RODIT => $prefix.'х',
                        static::DAT => $prefix.'м',
                        static::VINIT => $prefix.'е',
                        static::TVORIT => $prefix.'ми',
                        static::PREDLOJ => $prefix.'х',
                    ];

                // Керчь
                case 'чь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix.'ь',
                        static::RODIT => $prefix.'и',
                        static::DAT => $prefix.'и',
                        static::VINIT => $prefix.'ь',
                        static::TVORIT => $prefix.'ью',
                        static::PREDLOJ => $prefix.'и',
                    ];
            }

            switch (S::slice($name, -1)) {
                case 'р':
                    // Бор
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix.'р',
                        static::RODIT => $prefix.'ра',
                        static::DAT => $prefix.'ру',
                        static::VINIT => $prefix.'р',
                        static::TVORIT => $prefix.'ром',
                        static::PREDLOJ => $prefix.'ре',
                    ];

                case 'ы':
                    // Чебоксары, Шахты
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix.'ы',
                        static::RODIT => $prefix,
                        static::DAT => $prefix.'ам',
                        static::VINIT => $prefix.'ы',
                        static::TVORIT => $prefix.'ами',
                        static::PREDLOJ => $prefix.'ах',
                    ];

                case 'я':
                    // Азия
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix.'и',
                        static::DAT => $prefix.'и',
                        static::VINIT => $prefix.'ю',
                        static::TVORIT => $prefix.'ей',
                        static::PREDLOJ => $prefix.'и',
                    ];

                case 'а':
                    // Москва, Рига
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix.'а',
                        static::RODIT => $prefix.(static::isVelarConsonant(S::slice($name, -2, -1)) ? 'и' : 'ы'),
                        static::DAT => $prefix.'е',
                        static::VINIT => $prefix.'у',
                        static::TVORIT => $prefix.'ой',
                        static::PREDLOJ => $prefix.'е',
                    ];

                case 'й':
                    // Ишимбай
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => $prefix . 'й',
                        static::RODIT => $prefix . 'я',
                        static::DAT => $prefix . 'ю',
                        static::VINIT => $prefix . 'й',
                        static::TVORIT => $prefix . 'ем',
                        static::PREDLOJ => $prefix . 'е',
                    ];
            }

            if (static::isConsonant(S::slice($name,  -1)) && !in_array($name, static::$ovAbnormalExceptions, true)) {
                $runaway_vowels_list = static::getRunAwayVowelsList();

                // if run-away vowel in name
                if (isset($runaway_vowels_list[$name])) {
                    $runaway_vowel_offset = $runaway_vowels_list[$name];
                    $prefix = S::name(S::slice($name, 0, $runaway_vowel_offset) . S::slice($name, $runaway_vowel_offset + 1));
                } else {
                    $prefix = S::name($name);
                }

                // Париж, Валаам, Киев
                return [
                    static::IMENIT => S::name($name),
                    static::RODIT => $prefix . 'а',
                    static::DAT => $prefix . 'у',
                    static::VINIT => S::name($name),
                    static::TVORIT => $prefix . (static::isVelarConsonant(S::slice($name, -2, -1)) ? 'ем' : 'ом'),
                    static::PREDLOJ => $prefix . 'е',
                ];
            }

            // ов, ово, ёв, ёво, ев, ево, ...
            $suffixes = ['ов', 'ёв', 'ев', 'ин', 'ын'];
            if ((in_array(S::slice($name, -1), ['е', 'о'], true) && in_array(S::slice($name, -3, -1), $suffixes, true)) || in_array(S::slice($name, -2), $suffixes, true)) {
                // ово, ёво, ...
                if (in_array(S::slice($name, -3, -1), $suffixes, true)) {
                    $prefix = S::name(S::slice($name, 0, -1));
                }
                // ов, её, ...
                elseif (in_array(S::slice($name, -2), $suffixes, true)) {
                    $prefix = S::name($name);
                }
                return [
                    static::IMENIT => S::name($name),
                    static::RODIT => $prefix.'а',
                    static::DAT => $prefix.'у',
                    static::VINIT => S::name($name),
                    static::TVORIT => $prefix.'ым',
                    static::PREDLOJ => $prefix.'е',
                ];
            }
        }

        // if no rules matches or name is immutable
        $name = in_array($name, static::$abbreviations, true) ? S::upper($name) : S::name($name);
        return array_fill_keys([static::IMENIT, static::RODIT, static::DAT, static::VINIT, static::TVORIT, static::PREDLOJ], $name);
    }

    /**
     * Получение одной формы (падежа) названия.
     * @param string $name  Название
     * @param integer $case Падеж. Одна из констант \morphos\Russian\Cases или \morphos\Cases.
     * @see \morphos\Russian\Cases
     * @return string
     * @throws \Exception
     */
    public static function getCase($name, $case)
    {
        $case = static::canonizeCase($case);
        $forms = static::getCases($name);
        return $forms[$case];
    }
}
