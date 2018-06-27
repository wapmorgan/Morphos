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

    protected static $runawayVowelsNormalized = false;

    /**
     * @return array|bool
     */
    protected static function getRunAwayVowelsList()
    {
        if (self::$runawayVowelsNormalized === false) {
            self::$runawayVowelsNormalized = [];
            foreach (self::$runawayVowelsExceptions as $word) {
                self::$runawayVowelsNormalized[str_replace('*', null, $word)] = S::indexOf($word, '*') - 1;
            }
        }
        return self::$runawayVowelsNormalized;
    }

    /**
     * Склонение существительного для сочетания с числом (кол-вом предметов).
     * @param int|string $count Количество предметов
     * @param string|int $word Название предмета
     * @param bool $animateness Признак одушевленности
     * @return string
     * @throws \Exception
     */
    public static function pluralize($word, $count = 2, $animateness = false)
    {
        // меняем местами аргументы, если они переданы в старом формате
        if (is_string($count) && is_numeric($word)) {
            list($count, $word) = [$word, $count];
        }

        // для адъективных существительных правила склонения проще:
        // только две формы
        if (self::isAdjectiveNoun($word)) {
            if (self::getNumeralForm($count) == self::ONE)
                return $word;
            else
                return NounPluralization::getCase($word, self::RODIT, $animateness);
        }

        switch (self::getNumeralForm($count)) {
            case self::ONE:
                return $word;
            case self::TWO_FOUR:
                return NounDeclension::getCase($word, self::RODIT, $animateness);
            case self::FIVE_OTHER:
                // special case for YEAR >= 5
                if ($word === 'год') {
                    return 'лет';
                }

                return NounPluralization::getCase($word, self::RODIT, $animateness);
        }
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
            return self::ONE;
        } elseif (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4))) {
            return self::TWO_FOUR;
        } else {
            return self::FIVE_OTHER;
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
        $case = self::canonizeCase($case);
        $forms = self::getCases($word, $animateness);
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

        if (in_array($word, self::$immutableWords, true)) {
            return [
                self::IMENIT => $word,
                self::RODIT => $word,
                self::DAT => $word,
                self::VINIT => $word,
                self::TVORIT => $word,
                self::PREDLOJ => $word,
            ];
        }

        // Адъективное склонение (Сущ, образованные от прилагательных и причастий) - прохожий, существительное
        if (self::isAdjectiveNoun($word)) {
            return self::declinateAdjective($word, $animateness);
        }

        // Субстантивное склонение (существительные)
        return self::declinateSubstative($word, $animateness);
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
                        self::isConsonant(S::slice($word, -2, -1)) && !self::isHissingConsonant(S::slice($word, -2, -1)))
                        || S::slice($word, -2, -1) == 'и'));
            $prefix = NounDeclension::getPrefixOfSecondDeclension($word, $last);
        } elseif ($declension == NounDeclension::FIRST_DECLENSION) {
            $soft_last = self::checkLastConsonantSoftness($word);
        } else {
            $soft_last = in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true);
        }

        $forms = [];

        if ($last == 'ч' || in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true)
            || (self::isVowel($last) && in_array(S::slice($word, -2, -1), ['ч', 'к'], true))) { // before ч, чь, сь, ч+vowel, к+vowel
            $forms[Cases::IMENIT] = $prefix.'и';
        } elseif (in_array($last, ['н', 'ц', 'р', 'т'], true)) {
            $forms[Cases::IMENIT] = $prefix.'ы';
        } else {
            $forms[Cases::IMENIT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');
        }

        // RODIT
        if (isset(self::$genitiveExceptions[$word])) {
            $forms[Cases::RODIT] = self::$genitiveExceptions[$word];
        } elseif (in_array($last, ['о', 'е'], true)) {
            // exceptions
            if (in_array($word, self::$neuterExceptions, true)) {
                $forms[Cases::RODIT] = $prefix.'ей';
            } elseif (S::slice($word, -2, -1) == 'и') {
                $forms[Cases::RODIT] = $prefix.'й';
            } else {
                $forms[Cases::RODIT] = $prefix;
            }
        } elseif (S::slice($word, -2) == 'ка') { // words ending with -ка: чашка, вилка, ложка, тарелка, копейка, батарейка
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
        } else { // (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last))
            $forms[Cases::RODIT] = $prefix.'ов';
        }

        // DAT
        $forms[Cases::DAT] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ям', $prefix.'ам');

        // VINIT
        $forms[Cases::VINIT] = NounDeclension::getVinitCaseByAnimateness($forms, $animateness);

        // TVORIT
        // my personal rule
        if ($last == 'ь' && $declension == NounDeclension::THIRD_DECLENSION && !in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь'], true)) {
            $forms[Cases::TVORIT] = $prefix.'ми';
        } else {
            $forms[Cases::TVORIT] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ями', $prefix.'ами');
        }

        // PREDLOJ
        $forms[Cases::PREDLOJ] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ях', $prefix.'ах');
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
        $vowel = self::isHissingConsonant(S::slice($prefix, -1)) ? 'и' : 'ы';
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
