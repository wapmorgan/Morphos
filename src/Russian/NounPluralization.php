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

    protected static $neuterExceptions = array(
        'поле',
        'море',
    );

    protected static $genitiveExceptions = array(
        'письмо' => 'писем',
        'пятно' => 'пятен',
        'кресло' => 'кресел',
        'коромысло' => 'коромысел',
        'ядро' => 'ядер',
        'блюдце' => 'блюдец',
        'полотенце' => 'полотенец',
    );

    protected static $immutableWords = array(
        'евро',
        'пенни',
    );

    protected static $runawayVowelsExceptions = array(
        'писе*ц',
        'песе*ц',
        'глото*к',
    );

    protected static $runawayVowelsNormalized = false;

    protected static function getRunAwayVowelsList()
    {
        if (self::$runawayVowelsNormalized === false) {
            self::$runawayVowelsNormalized = array();
            foreach (self::$runawayVowelsExceptions as $word) {
                self::$runawayVowelsNormalized[str_replace('*', null, $word)] = S::indexOf($word, '*') - 1;
            }
        }
        return self::$runawayVowelsNormalized;
    }

    public static function pluralize($word, $count = 2, $animateness = false)
    {
        switch (self::getNumeralForm($count)) {
            case self::ONE:
                return $word;
            case self::TWO_FOUR:
                return NounDeclension::getCase($word, self::RODIT, $animateness);
            case self::FIVE_OTHER:
                return NounPluralization::getCase($word, self::RODIT, $animateness);
        }
    }

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

    public static function getCase($word, $case, $animateness = false)
    {
        $case = self::canonizeCase($case);
        $forms = self::getCases($word, $animateness);
        return $forms[$case];
    }

    public static function getCases($word, $animateness = false)
    {
        $word = S::lower($word);

        if (in_array($word, self::$immutableWords)) {
            return array(
                self::IMENIT => $word,
                self::RODIT => $word,
                self::DAT => $word,
                self::VINIT => $word,
                self::TVORIT => $word,
                self::PREDLOJ => self::choosePrepositionByFirstLetter($word, 'об', 'о').' '.$word,
            );
        }

        // Адъективное склонение (Сущ, образованные от прилагательных и причастий) - прохожий, существительное
        if (in_array(S::slice($word, -2), array('ой', 'ий', 'ый', 'ая', 'ое', 'ее')) && $word != 'гений') {
            return self::declinateAdjective($word, $animateness);
        }

        // Субстантивное склонение (существительные)
        return self::declinateSubstative($word, $animateness);
    }

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
            $soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && ((self::isConsonant(S::slice($word, -2, -1)) && !self::isHissingConsonant(S::slice($word, -2, -1))) || S::slice($word, -2, -1) == 'и'));
            $prefix = NounDeclension::getPrefixOfSecondDeclension($word, $last);
        } elseif ($declension == NounDeclension::FIRST_DECLENSION) {
            $soft_last = self::checkLastConsonantSoftness($word);
        } else {
            $soft_last = in_array(S::slice($word, -2), ['чь', 'сь', 'ть', 'нь']);
        }

        $forms = array();

        if ($last == 'ч' || in_array(S::slice($word, -2), array('чь', 'сь', 'ть', 'нь')) || (self::isVowel($last) && in_array(S::slice($word, -2, -1), array('ч', 'к')))) { // before ч, чь, сь, ч+vowel, к+vowel
            $forms[Cases::IMENIT] = $prefix.'и';
        } elseif ($last == 'н' || $last == 'ц') {
            $forms[Cases::IMENIT] = $prefix.'ы';
        } else {
            $forms[Cases::IMENIT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');
        }

        // RODIT
        if (isset(self::$genitiveExceptions[$word])) {
            $forms[Cases::RODIT] = self::$genitiveExceptions[$word];
        } elseif (in_array($last, array('о', 'е'))) {
            // exceptions
            if (in_array($word, self::$neuterExceptions)) {
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
        } elseif (in_array($last, array('а'))) { // обида, ябеда
            $forms[Cases::RODIT] = $prefix;
        } elseif (in_array($last, array('я'))) { // молния
            $forms[Cases::RODIT] = $prefix.'й';
        } elseif (RussianLanguage::isHissingConsonant($last) || ($soft_last && $last != 'й') || in_array(S::slice($word, -2), array('чь', 'сь', 'ть', 'нь'))) {
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
        if ($last == 'ь' && $declension == NounDeclension::THIRD_DECLENSION && !in_array(S::slice($word, -2), array('чь', 'сь', 'ть', 'нь'))) {
            $forms[Cases::TVORIT] = $prefix.'ми';
        } else {
            $forms[Cases::TVORIT] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ями', $prefix.'ами');
        }

        // PREDLOJ
        $forms[Cases::PREDLOJ] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ях', $prefix.'ах');
        $forms[Cases::PREDLOJ] = self::choosePrepositionByFirstLetter($forms[Cases::PREDLOJ], 'об', 'о').' '.$forms[Cases::PREDLOJ];
        return $forms;
    }

    /**
     * Rules are from http://rusgram.narod.ru/1216-1231.html
     */
    protected static function declinateAdjective($word, $animateness)
    {
        $prefix = S::slice($word, 0, -2);
        $vowel = self::isHissingConsonant(S::slice($prefix, -1)) ? 'и' : 'ы';
        return array(
            Cases::IMENIT => $prefix.$vowel.'е',
            Cases::RODIT => $prefix.$vowel.'х',
            Cases::DAT => $prefix.$vowel.'м',
            Cases::VINIT => $prefix.$vowel.($animateness ? 'х' : 'е'),
            Cases::TVORIT => $prefix.$vowel.'ми',
            Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.$vowel.'х',
        );
    }
}
