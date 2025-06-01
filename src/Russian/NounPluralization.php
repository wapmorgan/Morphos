<?php

namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class NounPluralization extends \morphos\BasePluralization implements Cases
{
    const ONE        = 1;
    const TWO_FOUR   = 2;
    const FIVE_OTHER = 3;

    /**
     * @var string[][]
     * @phpstan-var array<string, string[]>
     */
    protected static $abnormalExceptions = [
        'человек' => ['люди', 'человек', 'людям', 'людей', 'людьми', 'людях'],
        'дерево' => ['деревья', 'деревьев', 'деревьям', 'деревья', 'деревьями', 'деревьях'],
        'друг' => ['друзья', 'друзей', 'друзьям', 'друзей', 'друзьями', 'друзьях'],
    ];

    /** @var string[] */
    protected static $neuterExceptions = [
        'поле',
        'море',
    ];

    /**
     * @var string[]
     * @phpstan-var array<string, string>
     */
    protected static $genitiveExceptions = [
        'письмо'    => 'писем',
        'пятно'     => 'пятен',
        'кресло'    => 'кресел',
        'коромысло' => 'коромысел',
        'ядро'      => 'ядер',
        'блюдце'    => 'блюдец',
        'полотенце' => 'полотенец',
        'гривна'    => 'гривен',
        'год'       => 'лет',
    ];

    /**
     * Склонение существительного для сочетания с числом (кол-вом предметов).
     *
     * @param string|int $word        Название предмета
     * @param int|float|string $count Количество предметов
     * @param bool $animateness       Признак одушевленности
     * @param string $case            Род существительного
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

        if ($case !== null) {
            $case = RussianCasesHelper::canonizeCase($case);
        }

        // для адъективных существительных правила склонения проще:
        // только две формы
        if (RussianLanguage::isAdjectiveNoun($word)) {
            if (static::getNumeralForm($count) == static::ONE) {
                return $word;
            } else {
                return NounPluralization::getCase($word,
                    $case !== null
                        ? $case
                        : static::RODIT, $animateness);
            }
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

        if (static::getNumeralForm($count) == static::ONE) {
            return NounDeclension::getCase($word, $case, $animateness);
        } else {
            return NounPluralization::getCase($word, $case, $animateness);
        }
    }

    /**
     * @param int|float $count
     * @return int
     */
    public static function getNumeralForm($count)
    {
        if ($count > 100) {
            $count = (int) $count % 100;
        }
        $ending = (int) $count % 10;

        if (($count > 20 && $ending == 1) || $count == 1) {
            return static::ONE;
        } elseif (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4))) {
            return static::TWO_FOUR;
        } else {
            return static::FIVE_OTHER;
        }
    }

    /**
     * @param string $word
     * @param string $case
     * @param bool $animateness
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
     * @param string $word
     * @param bool $animateness
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($word, $animateness = false)
    {
        $word = S::lower($word);

        if (in_array($word, NounDeclension::$immutableWords, true)) {
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
            return array_combine(
                [static::IMENIT, static::RODIT, static::DAT, static::VINIT, static::TVORIT, static::PREDLOJ],
                static::$abnormalExceptions[$word]);
        }

        // Адъективное склонение (Сущ, образованные от прилагательных и причастий)
        // Пример: прохожий, существительное
        if (RussianLanguage::isAdjectiveNoun($word)) {
            return static::declinateAdjective($word, $animateness);
        }

        // Субстантивное склонение (существительные)
        return static::declinateSubstative($word, $animateness);
    }

    /**
     * Склонение существительных, образованных от прилагательных и причастий.
     * Rules are from http://rusgram.narod.ru/1216-1231.html
     * @param string $word
     * @param bool $animateness
     * @return string[]
     * @phpstan-return array<string, string>
     */
    protected static function declinateAdjective($word, $animateness)
    {
        $prefix = S::slice($word, 0, -2);
        $vowel  = RussianLanguage::isHissingConsonant(S::slice($prefix, -1)) ? 'и' : 'ы';
        return [
            Cases::IMENIT  => $prefix . $vowel . 'е',
            Cases::RODIT   => $prefix . $vowel . 'х',
            Cases::DAT     => $prefix . $vowel . 'м',
            Cases::VINIT   => $prefix . $vowel . ($animateness ? 'х' : 'е'),
            Cases::TVORIT  => $prefix . $vowel . 'ми',
            Cases::PREDLOJ => $prefix . $vowel . 'х',
        ];
    }

    /**
     * Склонение обычных существительных.
     * @param string $word
     * @param bool $animateness
     * @return string[]
     * @phpstan-return array<string, string>
     */
    protected static function declinateSubstative($word, $animateness)
    {
        $prefix = S::slice($word, 0, -1);
        $last   = S::slice($word, -1);

        if (($declension = NounDeclension::getDeclension($word)) == NounDeclension::SECOND_DECLENSION) {
            $soft_last = $last === 'й' || (
                in_array($last, ['ь', 'е', 'ё', 'ю', 'я'], true)
                && (
                    (
                        RussianLanguage::isConsonant(S::slice($word, -2, -1))
                        && !RussianLanguage::isHissingConsonant(S::slice($word, -2, -1))
                    )
                    || S::slice($word, -2, -1) == 'и'
                )
            );
            $prefix = NounDeclension::getPrefixOfSecondDeclension($word, $last);
        } elseif ($declension == NounDeclension::FIRST_DECLENSION) {
            $soft_last = RussianLanguage::checkLastConsonantSoftness($word);
        } else {
            $soft_last = in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь', 'дь'], true);
        }

        $forms = [];

        if (
            in_array($last, ['ч', 'г', 'ж', 'ш'], true)
            || in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь', 'рь', 'дь', 'ль'], true)
            || (RussianLanguage::isVowel($last) && in_array(S::slice($word, -2, -1), ['ч', 'к'], true))
        ) { // before ч, чь, сь, ч+vowel, к+vowel
            $forms[Cases::IMENIT] = $prefix . 'и';
        } elseif (in_array($last, ['н', 'ц', 'р', 'т', 'с'], true)) {
            $forms[Cases::IMENIT] = $prefix . 'ы';
        } else {
            // TODO: fix first declension (depends on animateness and gender, see test cases)
            $forms[Cases::IMENIT] = RussianLanguage::chooseVowelAfterConsonant($last, $soft_last, $prefix . 'я', $prefix . 'а');
        }

        // RODIT
        if (isset(static::$genitiveExceptions[$word])) {
            $forms[Cases::RODIT] = static::$genitiveExceptions[$word];
        } elseif (in_array($last, ['о', 'е'], true)) {
            // exceptions
            if (in_array($word, static::$neuterExceptions, true)) {
                $forms[Cases::RODIT] = $prefix . 'ей';
            } elseif (S::slice($word, -2, -1) == 'и') {
                $forms[Cases::RODIT] = $prefix . 'й';
            } else {
                $forms[Cases::RODIT] = $prefix;
            }
        } elseif (S::slice($word, -2) == 'ка') { // words ending with -ка: чашка, вилка, ложка, тарелка, копейка, батарейка, аптека
            if (in_array(S::slice($word, -3, -2), ['б', 'в', 'д', 'з', 'л', 'м', 'н', 'п', 'р', 'с', 'т', 'ф'], true)) {
                $forms[Cases::RODIT] = S::slice($word, 0, -2) . 'ок';
            } elseif (in_array(S::slice($word, -3, -2), ['ц', 'ч', 'ш', 'щ', 'ж'], true)) {
                $forms[Cases::RODIT] = S::slice($word, 0, -2) . 'ек';
            } elseif (S::slice($word, -3, -2) === 'й') {
                $forms[Cases::RODIT] = S::slice($word, 0, -3) . 'ек';
            } elseif (in_array(S::slice($word, -3, -2), array_merge(['е', 'к'], RussianLanguage::$vowels), true)) {
                $forms[Cases::RODIT] = $prefix;
            } else {
                $forms[Cases::RODIT] = S::slice($word, 0, -2) . 'ек';
            }
        } elseif ($last === 'а') { // обида, ябеда
            $forms[Cases::RODIT] = $prefix;
        } elseif ($last === 'я') { // молния
            $forms[Cases::RODIT] = $prefix . 'й';
        } elseif (
            RussianLanguage::isHissingConsonant($last)
            || ($soft_last && $last != 'й')
            || in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь', 'дь'], true)
        ) {
            $forms[Cases::RODIT] = $prefix . 'ей';
        } elseif ($last == 'й' || S::slice($word, -2) == 'яц') { // месяц
            $forms[Cases::RODIT] = $prefix . 'ев';
        } else { // (static::isConsonant($last) && !RussianLanguage::isHissingConsonant($last))
            $forms[Cases::RODIT] = $prefix . 'ов';
        }

        // DAT
        $forms[Cases::DAT] = RussianLanguage::chooseVowelAfterConsonant($last,
            $soft_last && S::slice($word, -2, -1) != 'ч', $prefix . 'ям', $prefix . 'ам');

        // VINIT
        $forms[Cases::VINIT] = RussianLanguage::getVinitCaseByAnimateness($forms, $animateness);

        // TVORIT
        // my personal rule
        if ($last == 'ь' && $declension == NounDeclension::THIRD_DECLENSION && !in_array(S::slice($word, -2),
                ['чь', 'сь', 'ть', 'нь', 'дь'], true)) {
            $forms[Cases::TVORIT] = $prefix . 'ми';
        } else {
            $forms[Cases::TVORIT] = RussianLanguage::chooseVowelAfterConsonant($last,
                $soft_last && S::slice($word, -2, -1) != 'ч', $prefix . 'ями', $prefix . 'ами');
        }

        // PREDLOJ
        $forms[Cases::PREDLOJ] = RussianLanguage::chooseVowelAfterConsonant($last,
            $soft_last && S::slice($word, -2, -1) != 'ч', $prefix . 'ях', $prefix . 'ах');
        return $forms;
    }
}
