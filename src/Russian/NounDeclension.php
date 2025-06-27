<?php

namespace morphos\Russian;

use morphos\BaseInflection;
use morphos\Gender;
use morphos\S;
use RuntimeException;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class NounDeclension extends BaseInflection implements Cases, Gender
{
    const FIRST_DECLENSION  = 1;
    const SECOND_DECLENSION = 2;
    const THIRD_DECLENSION  = 3;

    /** @var string[] */
    public static $immutableWords = [
        // валюты
        'евро',
        'тенге',
        'пенни',
        'песо',
        'сентаво',

        // на а
        'боа',
        'бра',
        'фейхоа',
        'амплуа',
        'буржуа',
        // на о
        'манго',
        'какао',
        'кино',
        'трюмо',
        'пальто',
        'бюро',
        'танго',
        'вето',
        'бунгало',
        'сабо',
        'авокадо',
        'депо',
        'панно',
        // на у
        'зебу',
        'кенгуру',
        'рагу',
        'какаду',
        'шоу',
        // на е
        'шимпанзе',
        'конферансье',
        'атташе',
        'колье',
        'резюме',
        'пенсне',
        'кашне',
        'протеже',
        'коммюнике',
        'драже',
        'суфле',
        'пюре',
        'купе',
        'фойе',
        'шоссе',
        'крупье',
        // на и
        'такси',
        'жалюзи',
        'шасси',
        'алиби',
        'киви',
        'иваси',
        'регби',
        'конфетти',
        'колибри',
        'жюри',
        'пенальти',
        'рефери',
        'кольраби',
        // на э
        'каноэ',
        'алоэ',
        // на ю
        'меню',
        'парвеню',
        'авеню',
        'дежавю',
        'инженю',
        'барбекю',
        'интервью',
    ];
    /** @var string[] */
    public static $runawayVowelsExceptions = [
        'глото*к',
        'де*нь',
        'каме*нь',
        'коре*нь',
        'паре*нь',
        'пе*нь',
        'песе*ц',
        'писе*ц',
        'санузе*л',
        'труте*нь',
    ];
    /**
     * These words has 2 declension type.
     * @var string[]|string[][]
     */
    protected static $abnormalExceptions = [
        'бремя',
        'вымя',
        'темя',
        'пламя',
        'стремя',
        'пламя',
        'время',
        'знамя',
        'имя',
        'племя',
        'семя',
        'путь' => ['путь', 'пути', 'пути', 'путь', 'путем', 'пути'],
        'дитя' => ['дитя', 'дитяти', 'дитяти', 'дитя', 'дитятей', 'дитяти'],
    ];
    /** @var string[] */
    protected static $masculineWithSoft = [
        'автослесарь',
        'библиотекарь',
        'водитель',
        'воспитатель',
        'врач',
        'выхухоль',
        'гвоздь',
        'делопроизводитель',
        'день',
        'дождь',
        'заместитель',
        'зверь',
        'издатель',
        'любитель',
        'камень',
        'конь',
        'конь',
        'корень',
        'лось',
        'медведь',
        'модуль',
        'олень',
        'парень',
        'пекарь',
        'пельмень',
        'пень',
        'покупатель',
        'пользователь',
        'председатель',
        'представитель',
        'преподаватель',
        'продавец',
        'производитель',
        'путь',
        'рояль',
        'рубль',
        'руководитель',
        'секретарь',
        'слесарь',
        'строитель',
        'табель',
        'токарь',
        'трутень',
        'тюлень',
        'учитель',
        'циркуль',
        'шампунь',
        'шкворень',
        'юань',
        'ячмень',
    ];

    /**
     * Проверка, изменяемое ли слово.
     * @param string $word      Слово для проверки
     * @param bool $animateness Признак одушевленности
     * @return bool
     */
    public static function isMutable($word, $animateness = false)
    {
        $word = S::lower($word);
        if (in_array(S::slice($word, -1), ['у', 'и', 'е', 'о', 'ю'], true) || in_array($word, static::$immutableWords,
                true)) {
            return false;
        }
        return true;
    }

    /**
     * Определение рода существительного.
     * @param string $word
     * @return string
     */
    public static function detectGender($word)
    {
        $word = S::lower($word);
        $last = S::slice($word, -1);
        // пытаемся угадать род объекта, хотя бы примерно, чтобы правильно склонять
        if (S::slice($word, -2) == 'мя' || in_array($last, ['о', 'е', 'и', 'у'], true)) {
            return static::NEUTER;
        }

        if (in_array($last, ['а', 'я'], true) ||
            ($last == 'ь' && !in_array($word, static::$masculineWithSoft, true))) {
            return static::FEMALE;
        }

        return static::MALE;
    }

    /**
     * Получение одной формы слова (падежа).
     * @param string $word      Слово
     * @param string $case      Падеж
     * @param bool $animateness Признак одушевленности
     * @return string
     * @throws \Exception
     */
    public static function getCase($word, $case, $animateness = false)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($word, $animateness);
        return $forms[$case];
    }

    /**
     * Получение слова во всех 6 падежах.
     * @param string $word
     * @param bool $animateness Признак одушевлённости
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($word, $animateness = false)
    {
        $word = S::lower($word);

        // Адъективное склонение (Сущ, образованные от прилагательных и причастий) - прохожий, существительное
        if (RussianLanguage::isAdjectiveNoun($word)) {
            return static::declinateAdjective($word, $animateness);
        }

        // Субстантивное склонение (существительные)
        if (in_array($word, static::$immutableWords, true)) {
            return [
                static::IMENIT  => $word,
                static::RODIT   => $word,
                static::DAT     => $word,
                static::VINIT   => $word,
                static::TVORIT  => $word,
                static::PREDLOJ => $word,
            ];
        }

        if (isset(static::$abnormalExceptions[$word])) {
            return array_combine([
                static::IMENIT,
                static::RODIT,
                static::DAT,
                static::VINIT,
                static::TVORIT,
                static::PREDLOJ,
            ], static::$abnormalExceptions[$word]);
        }

        if (in_array($word, static::$abnormalExceptions, true)) {
            $prefix = S::slice($word, 0, -1);
            return [
                static::IMENIT  => $word,
                static::RODIT   => $prefix . 'ени',
                static::DAT     => $prefix . 'ени',
                static::VINIT   => $word,
                static::TVORIT  => $prefix . 'енем',
                static::PREDLOJ => $prefix . 'ени',
            ];
        }

        switch (static::getDeclension($word)) {
            case static::FIRST_DECLENSION:
                return static::declinateFirstDeclension($word);
            case static::SECOND_DECLENSION:
                return static::declinateSecondDeclension($word, $animateness);
            case static::THIRD_DECLENSION:
                return static::declinateThirdDeclension($word);

            default:
                throw new RuntimeException('Unreachable');
        }
    }

    /**
     * Склонение существительных, образованных от прилагательных и причастий.
     * Rules are from http://rusgram.narod.ru/1216-1231.html
     * @param string $word
     * @param bool $animateness
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function declinateAdjective($word, $animateness)
    {
        $prefix = S::slice($word, 0, -2);

        switch (S::slice($word, -2)) {
            // Male adjectives
            case 'ой':
            case 'ый':
                return [
                    Cases::IMENIT  => $word,
                    Cases::RODIT   => $prefix . 'ого',
                    Cases::DAT     => $prefix . 'ому',
                    Cases::VINIT   => $word,
                    Cases::TVORIT  => $prefix . 'ым',
                    Cases::PREDLOJ => $prefix . 'ом',
                ];

            case 'ий':
                return [
                    Cases::IMENIT  => $word,
                    Cases::RODIT   => $prefix . 'его',
                    Cases::DAT     => $prefix . 'ему',
                    Cases::VINIT   => $prefix . 'его',
                    Cases::TVORIT  => $prefix . 'им',
                    Cases::PREDLOJ => $prefix . 'ем',
                ];

            // Neuter adjectives
            case 'ое':
            case 'ее':
                $prefix = S::slice($word, 0, -1);
                return [
                    Cases::IMENIT  => $word,
                    Cases::RODIT   => $prefix . 'го',
                    Cases::DAT     => $prefix . 'му',
                    Cases::VINIT   => $word,
                    Cases::TVORIT  => S::slice($word, 0, -2) . (S::slice($word, -2, -1) == 'о' ? 'ы' : 'и') . 'м',
                    Cases::PREDLOJ => $prefix . 'м',
                ];

            // Female adjectives
            case 'ая':
                $ending = RussianLanguage::isHissingConsonant(S::slice($prefix, -1)) ? 'ей' : 'ой';
                return [
                    Cases::IMENIT  => $word,
                    Cases::RODIT   => $prefix . $ending,
                    Cases::DAT     => $prefix . $ending,
                    Cases::VINIT   => $prefix . 'ую',
                    Cases::TVORIT  => $prefix . $ending,
                    Cases::PREDLOJ => $prefix . $ending,
                ];

            default:
                throw new RuntimeException('Unreachable');
        }
    }

    /**
     * Определение склонения (по школьной программе) существительного.
     * @param string $word
     * @param bool $animateness
     * @return int
     */
    public static function getDeclension($word, $animateness = false)
    {
        $word = S::lower($word);
        $last = S::slice($word, -1);
        if (isset(static::$abnormalExceptions[$word]) || in_array($word, static::$abnormalExceptions, true)) {
            return self::SECOND_DECLENSION;
        }

        if (in_array($last, ['а', 'я'], true) && S::slice($word, -2) != 'мя') {
            return self::FIRST_DECLENSION;
        } elseif (
            RussianLanguage::isConsonant($last)
            || in_array($last, ['о', 'е', 'ё'], true)
            || (
                $last == 'ь'
                && RussianLanguage::isConsonant(S::slice($word, -2, -1))
                && !RussianLanguage::isHissingConsonant(S::slice($word, -2, -1))
                && (in_array($word, static::$masculineWithSoft, true))
                /*|| in_array($word, static::$masculineWithSoftAndRunAwayVowels, true)*/
            )
        ) {
            return self::SECOND_DECLENSION;
        } else {
            return self::THIRD_DECLENSION;
        }
    }

    /**
     * Получение всех форм слова первого склонения.
     * @param string $word
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function declinateFirstDeclension($word)
    {
        $word      = S::lower($word);
        $prefix    = S::slice($word, 0, -1);
        $last      = S::slice($word, -1);
        $soft_last = RussianLanguage::checkLastConsonantSoftness($word);
        $forms     = [
            Cases::IMENIT => $word,
        ];

        // RODIT
        $forms[Cases::RODIT] = RussianLanguage::chooseVowelAfterConsonant($last,
            $soft_last || (in_array(S::slice($word, -2, -1), ['г', 'к', 'х'], true)), $prefix . 'и', $prefix . 'ы');

        // DAT
        $forms[Cases::DAT] = static::getPredCaseOf12Declensions($word, $last, $prefix);

        // VINIT
        $forms[Cases::VINIT] = RussianLanguage::chooseVowelAfterConsonant($last,
            $soft_last && S::slice($word, -2, -1) !== 'ч', $prefix . 'ю', $prefix . 'у');

        // TVORIT
        if ($last === 'ь') {
            $forms[Cases::TVORIT] = $prefix . 'ой';
        } else {
            $forms[Cases::TVORIT] = RussianLanguage::chooseVowelAfterConsonant($last, $soft_last, $prefix . 'ей',
                $prefix . 'ой');
        }

        // 	if ($last == 'й' || (static::isConsonant($last) && !static::isHissingConsonant($last)) || static::checkLastConsonantSoftness($word))
        // 	$forms[Cases::TVORIT] = $prefix.'ей';
        // else
        // 	$forms[Cases::TVORIT] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant

        // PREDLOJ the same as DAT
        $forms[Cases::PREDLOJ] = $forms[Cases::DAT];
        return $forms;
    }

    /**
     * @param string $word
     * @param string $last
     * @param string $prefix
     * @return string
     */
    public static function getPredCaseOf12Declensions($word, $last, $prefix)
    {
        if (in_array(S::slice($word, -2), ['ий', 'ие', 'ия'], true)) {
            if ($last == 'ё') {
                return $prefix . 'е';
            } else {
                return $prefix . 'и';
            }
        } else {
            return $prefix . 'е';
        }
    }

    /**
     * Получение всех форм слова второго склонения.
     * @param string $word
     * @param bool $animateness
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function declinateSecondDeclension($word, $animateness = false)
    {
        $word         = S::lower($word);
        $last         = S::slice($word, -1);
        $beforeLast   = S::slice($word, -2, -1);
        $isSoftEnding = in_array($last, ['ь', 'е', 'ё', 'ю', 'я', 'й'], true)
            && !RussianLanguage::isHissingConsonant($beforeLast);
        $prefix       = static::getPrefixOfSecondDeclension($word, $last);
        $forms        = [
            Cases::IMENIT => $word,
        ];

        // RODIT
        $forms[Cases::RODIT] = RussianLanguage::chooseVowelAfterConsonant($last, $isSoftEnding, $prefix . 'я',
            $prefix . 'а');

        // DAT
        $forms[Cases::DAT] = RussianLanguage::chooseVowelAfterConsonant($last, $isSoftEnding, $prefix . 'ю',
            $prefix . 'у');

        // VINIT
        if (in_array($last, ['о', 'е', 'ё'], true)) {
            $forms[Cases::VINIT] = $word;
        } else {
            $forms[Cases::VINIT] = RussianLanguage::getVinitCaseByAnimateness($forms, $animateness);
        }

        // TVORIT
        // if ($last == 'ь')
        // 	$forms[Cases::TVORIT] = $prefix.'ом';
        // else if ($last == 'й' || (static::isConsonant($last) && !static::isHissingConsonant($last)))
        // 	$forms[Cases::TVORIT] = $prefix.'ем';
        // else
        // 	$forms[Cases::TVORIT] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
        if ((RussianLanguage::isHissingConsonant($last) && $last !== 'ш')
            || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я'], true) && RussianLanguage::isHissingConsonant($beforeLast))
            || ($last === 'ц' && S::slice($word, -2) !== 'ец')) {
            $forms[Cases::TVORIT] = $prefix . 'ем';
        } elseif (in_array($last, ['й'/*, 'ч', 'щ'*/], true) || $isSoftEnding) {
            $forms[Cases::TVORIT] = $prefix . 'ем';
        } else {
            $forms[Cases::TVORIT] = $prefix . 'ом';
        }

        // PREDLOJ
        $forms[Cases::PREDLOJ] = static::getPredCaseOf12Declensions($word, $last, $prefix);

        return $forms;
    }

    /**
     * @param string $word
     * @param string $last
     * @return string
     */
    public static function getPrefixOfSecondDeclension($word, $last)
    {
        // слова с бегающей гласной в корне
        $runaway_vowels_list = static::getRunAwayVowelsList();
        if (isset($runaway_vowels_list[$word])) {
            $vowel_offset = $runaway_vowels_list[$word];
            $word         = S::slice($word, 0, $vowel_offset) . S::slice($word, $vowel_offset + 1);
        }

        if (in_array($last, ['о', 'е', 'ё', 'ь', 'й'], true)) {
            $prefix = S::slice($word, 0, -1);
        } // уменьшительные формы слов (котенок) и слова с суффиксом ок
        elseif (in_array(S::slice($word, -3), ['чок', 'лок', 'нок']) && S::length($word) > 3) {
            $prefix = S::slice($word, 0, -2) . 'к';
        } // слова с суффиксом бец
        elseif (S::slice($word, -3) === 'бец' && S::length($word) > 4) {
            $prefix = S::slice($word, 0, -3) . 'бц';
        } else {
            $prefix = $word;
        }
        return $prefix;
    }

    /**
     * @return int[]|false[]
     */
    public static function getRunAwayVowelsList()
    {
        $runawayVowelsNormalized = [];
        foreach (NounDeclension::$runawayVowelsExceptions as $word) {
            $runawayVowelsNormalized[str_replace('*', '', $word)] = S::indexOf($word, '*') - 1;
        }
        return $runawayVowelsNormalized;
    }

    /**
     * Получение всех форм слова третьего склонения.
     * @param string $word
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function declinateThirdDeclension($word)
    {
        $word   = S::lower($word);
        $prefix = S::slice($word, 0, -1);
        return [
            Cases::IMENIT  => $word,
            Cases::RODIT   => $prefix . 'и',
            Cases::DAT     => $prefix . 'и',
            Cases::VINIT   => $word,
            Cases::TVORIT  => $prefix . 'ью',
            Cases::PREDLOJ => $prefix . 'и',
        ];
    }
}
