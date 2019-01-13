<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class NounPluralization extends \morphos\NounPluralization implements Cases
{
    use RussianLanguage, CasesHelper;

    const ONE = 1;
    const TWO_FOUR = 2;
    const FIVE_OTHER = 3;

    protected static $abnormalExceptions = [
        'человек' => ['люди', 'человек', 'людям', 'людей', 'людьми', 'людях'],
    ];

    protected static $neuterExceptions = [
        'поле',
        'море',
    ];

    protected static $genitiveExceptions = [
        'письмо' => 'писем',
        'пятно' => 'пятен',
        'кресло' => 'кресел',
        'коромысло' => 'коромысел',
        'ядро' => 'ядер',
        'блюдце' => 'блюдец',
        'полотенце' => 'полотенец',
        'гривна' => 'гривен',
        'год' => 'лет',
    ];

    protected static $immutableWords = [
        'евро',
        'пенни',
    ];

    protected static $runawayVowelsExceptions = [
        'писе*ц',
        'песе*ц',
        'глото*к',
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
     * Склонение существительного для сочетания с числом (кол-вом предметов).
     *
     * @param string|int $word        Название предмета
     * @param int|string $count       Количество предметов
     * @param bool       $animateness Признак одушевленности
     * @param string     $case        Род существительного
     *
     * @return string
     * @throws \Exception
     */
    public static function pluralize($word, $count = 2, $animateness = false, $case = null)
    {
        // меняем местами аргументы, если они переданы в старом формате
        if (is_string($count) && is_numeric($word)) {
            list($count, $word) = [$word, $count];
        }

        if ($case !== null)
            $case = static::canonizeCase($case);

        // для адъективных существительных правила склонения проще:
        // только две формы
        if (static::isAdjectiveNoun($word)) {
            if (static::getNumeralForm($count) == static::ONE)
                return $word;
            else
                return NounPluralization::getCase($word,
                    $case !== null
                        ? $case
                        : static::RODIT, $animateness);
        }

        if ($case === null) {
            switch (static::getNumeralForm($count)) {
                case static::ONE:
                    return $word;
                case static::TWO_FOUR:
                    return NounDeclension::getCase($word, static::RODIT, $animateness);
                case static::FIVE_OTHER:
                    return NounPluralization::getCase($word, static::RODIT, $animateness);
            }
        }

        if (static::getNumeralForm($count) == static::ONE)
            return NounDeclension::getCase($word, $case, $animateness);
        else
            return NounPluralization::getCase($word, $case, $animateness);
    }

    /**
     * @param $count
     * @return int
     */
    public static function getNumeralForm($count)
    {
        if ($count > 100) {
            $count %= 100;
        }
        $ending = $count % 10;

        if (($count > 20 && $ending == 1) || $count == 1) {
            return static::ONE;
        } elseif (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4))) {
            return static::TWO_FOUR;
        } else {
            return static::FIVE_OTHER;
        }
    }

    /**
     * @param $word
     * @param $case
     * @param bool $animateness
     * @return string
     * @throws \Exception
     */
    public static function getCase($word, $case, $animateness = false)
    {
        $case = static::canonizeCase($case);
        $forms = static::getCases($word, $animateness);
        return $forms[$case];
    }

    /**
     * @param $word
     * @param bool $animateness
     * @return array
     */
    public static function getCases($word, $animateness = false)
    {
        $word = S::lower($word);

        if (in_array($word, static::$immutableWords, true)) {
            return [
                static::IMENIT => $word,
                static::RODIT => $word,
                static::DAT => $word,
                static::VINIT => $word,
                static::TVORIT => $word,
                static::PREDLOJ => $word,
            ];
        }

        if (isset(static::$abnormalExceptions[$word])) {
            return array_combine(
                [static::IMENIT, static::RODIT, static::DAT, static::VINIT, static::TVORIT, static::PREDLOJ],
                static::$abnormalExceptions[$word]);
        }

        // Адъективное склонение (Сущ, образованные от прилагательных и причастий)
        // Пример: прохожий, существительное
        if (static::isAdjectiveNoun($word)) {
            return static::declinateAdjective($word, $animateness);
        }

        // Субстантивное склонение (существительные)
        return static::declinateSubstative($word, $animateness);
    }

    /**
     * Склонение обычных существительных.
     * @param $word
     * @param $animateness
     * @return array
     */
    protected static function declinateSubstative($word, $animateness)
    {
        $prefix = S::slice($word, 0, -1);
        $last = S::slice($word, -1);

        $runaway_vowels_list = static::getRunAwayVowelsList();
        if (isset($runaway_vowels_list[$word])) {
            $vowel_offset = $runaway_vowels_list[$word];
            $word = S::slice($word, 0, $vowel_offset) . S::slice($word, $vowel_offset + 1);
        }

        if (($declension = NounDeclension::getDeclension($word)) == NounDeclension::SECOND_DECLENSION) {
            $soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я'], true)
                    && ((
                        static::isConsonant(S::slice($word, -2, -1)) && !static::isHissingConsonant(S::slice($word, -2, -1)))
                        || S::slice($word, -2, -1) == 'и'));
            $prefix = NounDeclension::getPrefixOfSecondDeclension($word, $last);
        } elseif ($declension == NounDeclension::FIRST_DECLENSION) {
            $soft_last = static::checkLastConsonantSoftness($word);
        } else {
            $soft_last = in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true);
        }

        $forms = [];

        if (in_array($last, ['ч', 'г'], false) || in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true)
            || (static::isVowel($last) && in_array(S::slice($word, -2, -1), ['ч', 'к'], true))) { // before ч, чь, сь, ч+vowel, к+vowel
            $forms[Cases::IMENIT] = $prefix.'и';
        } elseif (in_array($last, ['н', 'ц', 'р', 'т'], true)) {
            $forms[Cases::IMENIT] = $prefix.'ы';
        } else {
            $forms[Cases::IMENIT] = static::chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');
        }

        // RODIT
        if (isset(static::$genitiveExceptions[$word])) {
            $forms[Cases::RODIT] = static::$genitiveExceptions[$word];
        } elseif (in_array($last, ['о', 'е'], true)) {
            // exceptions
            if (in_array($word, static::$neuterExceptions, true)) {
                $forms[Cases::RODIT] = $prefix.'ей';
            } elseif (S::slice($word, -2, -1) == 'и') {
                $forms[Cases::RODIT] = $prefix.'й';
            } else {
                $forms[Cases::RODIT] = $prefix;
            }
        } elseif (S::slice($word, -2) == 'ка' && S::slice($word, -3, -2) !== 'и') { // words ending with -ка: чашка, вилка, ложка, тарелка, копейка, батарейка
            if (S::slice($word, -3, -2) == 'л') {
                $forms[Cases::RODIT] = S::slice($word, 0, -2).'ок';
            } elseif (S::slice($word, -3, -2) == 'й') {
                $forms[Cases::RODIT] = S::slice($word, 0, -3).'ек';
            } else {
                $forms[Cases::RODIT] = S::slice($word, 0, -2).'ек';
            }
        } elseif (in_array($last, ['а'], true)) { // обида, ябеда
            $forms[Cases::RODIT] = $prefix;
        } elseif (in_array($last, ['я'], true)) { // молния
            $forms[Cases::RODIT] = $prefix.'й';
        } elseif (RussianLanguage::isHissingConsonant($last) || ($soft_last && $last != 'й') || in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true)) {
            $forms[Cases::RODIT] = $prefix.'ей';
        } elseif ($last == 'й' || S::slice($word, -2) == 'яц') { // месяц
            $forms[Cases::RODIT] = $prefix.'ев';
        } else { // (static::isConsonant($last) && !RussianLanguage::isHissingConsonant($last))
            $forms[Cases::RODIT] = $prefix.'ов';
        }

        // DAT
        $forms[Cases::DAT] = static::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ям', $prefix.'ам');

        // VINIT
        $forms[Cases::VINIT] = NounDeclension::getVinitCaseByAnimateness($forms, $animateness);

        // TVORIT
        // my personal rule
        if ($last == 'ь' && $declension == NounDeclension::THIRD_DECLENSION && !in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true)) {
            $forms[Cases::TVORIT] = $prefix.'ми';
        } else {
            $forms[Cases::TVORIT] = static::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ями', $prefix.'ами');
        }

        // PREDLOJ
        $forms[Cases::PREDLOJ] = static::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ях', $prefix.'ах');
        return $forms;
    }

    /**
     * Склонение существительных, образованных от прилагательных и причастий.
     * Rules are from http://rusgram.narod.ru/1216-1231.html
     * @param $word
     * @param $animateness
     * @return array
     */
    protected static function declinateAdjective($word, $animateness)
    {
        $prefix = S::slice($word, 0, -2);
        $vowel = static::isHissingConsonant(S::slice($prefix, -1)) ? 'и' : 'ы';
        return [
            Cases::IMENIT => $prefix.$vowel.'е',
            Cases::RODIT => $prefix.$vowel.'х',
            Cases::DAT => $prefix.$vowel.'м',
            Cases::VINIT => $prefix.$vowel.($animateness ? 'х' : 'е'),
            Cases::TVORIT => $prefix.$vowel.'ми',
            Cases::PREDLOJ => $prefix.$vowel.'х',
        ];
    }
}
