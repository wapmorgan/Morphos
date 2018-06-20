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

        if (in_array($name, self::$abbreviations, true) || in_array($name, self::$immutableParts, true)) {
            return false;
        }

        // N край
        if (S::slice($name, -5) == ' край') {
            return static::isMutable(S::slice($name, 0, -5));
        }

        // N область
        if (S::slice($name, -8) == ' область') {
            return true;
        }

        // город N
        if (S::slice($name, 0, 6) == 'город ') {
            return true;
        }

        // село N
        if (S::slice($name, 0, 5) == 'село ') {
            return true;
        }

        // хутор N
        if (S::slice($name, 0, 6) == 'хутор ') {
            return true;
        }

        // пгт N
        if (S::slice($name, 0, 4) == 'пгт ') {
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

        if (in_array($name, self::$immutableParts, true)) {
            return array_fill_keys([self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ], S::name($name));
        }

        if (strpos($name, ' ') !== false) {
            $first_part = S::slice($name, 0, S::findFirstPosition($name, ' '));
            // город N, село N, хутор N, пгт N
            if (in_array($first_part, ['город', 'село', 'хутор', 'пгт'], true)) {
                if ($first_part !== 'пгт')
                    return self::composeCasesFromWords([
                        NounDeclension::getCases($first_part),
                        array_fill_keys(self::getAllCases(), S::name(S::slice($name, S::length($first_part) + 1)))
                    ]);
                else
                    return array_fill_keys([self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ], 'пгт '.S::name(S::slice($name, 4)));
            }

            $last_part = S::slice($name,
                S::findLastPosition($name, ' ') + 1);
            // N область, N край
            if (in_array($last_part, ['край', 'область'], true)) {
                return self::composeCasesFromWords([static::getCases(S::slice($name, 0, S::findLastPosition($name, ' '))), NounDeclension::getCases($last_part)]);
            }
        }

        // Сложное название через пробел, '-' или '-на-'
        foreach (self::$delimiters as $delimiter) {
            if (strpos($name, $delimiter) !== false) {
                $parts = explode($delimiter, $name);
                $result = [];
                foreach ($parts as $i => $part) {
                    $result[$i] = static::getCases($part);
                }
                return self::composeCasesFromWords($result, $delimiter);
            }
        }

        if (!in_array($name, self::$abbreviations, true)) {
            switch (S::slice($name, -2)) {
                // Нижний, Русский
                case 'ий':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        self::IMENIT => $prefix . 'ий',
                        self::RODIT => $prefix . (self::isVelarConsonant(S::slice($name, -3, -2)) ? 'ого' : 'его'),
                        self::DAT => $prefix . (self::isVelarConsonant(S::slice($name, -3, -2)) ? 'ому' : 'ему'),
                        self::VINIT => $prefix . 'ий',
                        self::TVORIT => $prefix . 'им',
                        self::PREDLOJ => $prefix . (self::chooseEndingBySonority($prefix, 'ем', 'ом')),
                    ];

                // Ростовская
                case 'ая':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        self::IMENIT => $prefix . 'ая',
                        self::RODIT => $prefix . 'ой',
                        self::DAT => $prefix . 'ой',
                        self::VINIT => $prefix . 'ую',
                        self::TVORIT => $prefix . 'ой',
                        self::PREDLOJ => $prefix . 'ой',
                    ];

                // Грозный, Благодарный
                case 'ый':
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        self::IMENIT => $prefix . 'ый',
                        self::RODIT => $prefix . 'ого',
                        self::DAT => $prefix . 'ому',
                        self::VINIT => $prefix . 'ый',
                        self::TVORIT => $prefix . 'ым',
                        self::PREDLOJ => $prefix . 'ом',
                    ];

                // Ставрополь, Ярославль
                case 'ль':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'ь',
                        self::RODIT => $prefix . 'я',
                        self::DAT => $prefix . 'ю',
                        self::VINIT => $prefix . 'ь',
                        self::TVORIT => $prefix . 'ем',
                        self::PREDLOJ => $prefix . 'е',
                    ];

                // Тверь, Анадырь
                case 'рь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    $last_vowel = S::slice($prefix, -2, -1);
                    return [
                        self::IMENIT => $prefix . 'ь',
                        self::RODIT => $prefix . (self::isBinaryVowel($last_vowel) ? 'и' : 'я'),
                        self::DAT => $prefix . (self::isBinaryVowel($last_vowel) ? 'и' : 'ю'),
                        self::VINIT => $prefix . 'ь',
                        self::TVORIT => $prefix . (self::isBinaryVowel($last_vowel) ? 'ью' : 'ем'),
                        self::PREDLOJ => $prefix . (self::isBinaryVowel($last_vowel) ? 'и' : 'е'),
                    ];

                // Березники, Ессентуки
                case 'ки':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'и',
                        self::RODIT => $name == 'луки' ? $prefix : $prefix . 'ов',
                        self::DAT => $prefix . 'ам',
                        self::VINIT => $prefix . 'и',
                        self::TVORIT => $prefix . 'ами',
                        self::PREDLOJ => $prefix . 'ах',
                    ];

                // Пермь, Кемь
                case 'мь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'ь',
                        self::RODIT => $prefix . 'и',
                        self::DAT => $prefix . 'и',
                        self::VINIT => $prefix . 'ь',
                        self::TVORIT => $prefix . 'ью',
                        self::PREDLOJ => $prefix . 'и',
                    ];

                // Рязань, Назрань
                case 'нь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'ь',
                        self::RODIT => $prefix . 'и',
                        self::DAT => $prefix . 'и',
                        self::VINIT => $prefix . 'ь',
                        self::TVORIT => $prefix . 'ью',
                        self::PREDLOJ => $prefix . 'и',
                    ];

                // Набережные
                case 'ые':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'е',
                        self::RODIT => $prefix . 'х',
                        self::DAT => $prefix . 'м',
                        self::VINIT => $prefix . 'е',
                        self::TVORIT => $prefix . 'ми',
                        self::PREDLOJ => $prefix . 'х',
                    ];

                // Челны
                case 'ны':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'ы',
                        self::RODIT => $prefix . 'ов',
                        self::DAT => $prefix . 'ам',
                        self::VINIT => $prefix . 'ы',
                        self::TVORIT => $prefix . 'ами',
                        self::PREDLOJ => $prefix . 'ах',
                    ];

                // Великие
                case 'ие':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix.'е',
                        self::RODIT => $prefix.'х',
                        self::DAT => $prefix.'м',
                        self::VINIT => $prefix.'е',
                        self::TVORIT => $prefix.'ми',
                        self::PREDLOJ => $prefix.'х',
                    ];

                // Керчь
                case 'чь':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix.'ь',
                        self::RODIT => $prefix.'и',
                        self::DAT => $prefix.'и',
                        self::VINIT => $prefix.'ь',
                        self::TVORIT => $prefix.'ью',
                        self::PREDLOJ => $prefix.'и',
                    ];
            }


            switch (S::slice($name, -1)) {
                // Азия
                case 'я':
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => S::name($name),
                        self::RODIT => $prefix.'и',
                        self::DAT => $prefix.'и',
                        self::VINIT => $prefix.'ю',
                        self::TVORIT => $prefix.'ей',
                        self::PREDLOJ => $prefix.'и',
                    ];

                case 'а':
                    // Москва, Рига
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix.'а',
                        self::RODIT => $prefix.(self::isVelarConsonant(S::slice($name, -2, -1)) ? 'и' : 'ы'),
                        self::DAT => $prefix.'е',
                        self::VINIT => $prefix.'у',
                        self::TVORIT => $prefix.'ой',
                        self::PREDLOJ => $prefix.'е',
                    ];

                case 'й':
                    // Ишимбай
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        self::IMENIT => $prefix . 'й',
                        self::RODIT => $prefix . 'я',
                        self::DAT => $prefix . 'ю',
                        self::VINIT => $prefix . 'й',
                        self::TVORIT => $prefix . 'ем',
                        self::PREDLOJ => $prefix . 'е',
                    ];
            }

            if (self::isConsonant(S::slice($name,  -1)) && !in_array($name, self::$ovAbnormalExceptions, true)) {
                // Париж, Валаам, Киев
                $prefix = S::name($name);
                return [
                    self::IMENIT => $prefix,
                    self::RODIT => $prefix . 'а',
                    self::DAT => $prefix . 'у',
                    self::VINIT => $prefix,
                    self::TVORIT => $prefix . (self::isVelarConsonant(S::slice($name, -2, -1)) ? 'ем' : 'ом'),
                    self::PREDLOJ => $prefix . 'е',
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
                    self::IMENIT => S::name($name),
                    self::RODIT => $prefix.'а',
                    self::DAT => $prefix.'у',
                    self::VINIT => S::name($name),
                    self::TVORIT => $prefix.'ым',
                    self::PREDLOJ => $prefix.'е',
                ];
            }
        }

        // if no rules matches or name is immutable
        $name = in_array($name, self::$abbreviations, true) ? S::upper($name) : S::name($name);
        return array_fill_keys([self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ], $name);
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
        $case = self::canonizeCase($case);
        $forms = self::getCases($name);
        return $forms[$case];
    }
}
