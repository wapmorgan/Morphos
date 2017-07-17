<?php
namespace morphos\Russian;

use morphos\Gender;
use morphos\S;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class NounDeclension extends \morphos\BaseInflection implements Cases, Gender
{
    use RussianLanguage, CasesHelper;

    const FIRST_DECLENSION = 1;
    const SECOND_DECLENSION = 2;
    const THIRD_DECLENSION = 3;

    /**
     * These words has 2 declension type.
     */
    protected static $abnormalExceptions = array(
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
        'путь' => array('путь', 'пути', 'пути', 'путь', 'путем', 'о пути'),
        'дитя' => array('дитя', 'дитяти', 'дитяти', 'дитя', 'дитятей', 'о дитяти')
    );

    protected static $masculineWithSoft = array(
        'олень',
        'конь',
        'ячмень',
        'путь',
        'зверь',
        'шкворень',
        'пельмень',
        'тюлень',
        'выхухоль',
        'табель',
        'рояль',
        'шампунь',
        'конь',
        'лось',
        'гвоздь',
        'медведь',
        'рубль',
        'дождь',
    );

    protected static $masculineWithSoftAndRunAwayVowels = array(
        'день',
        'пень',
        'парень',
        'камень',
        'корень',
        'трутень',
    );

    protected static $immutableWords = array(
        'евро',
        'пенни',
    );

    public static function isMutable($word, $animateness = false)
    {
        $word = S::lower($word);
        if (in_array(S::slice($word, -1), array('у', 'и', 'е', 'о', 'ю')) || in_array($word, self::$immutableWords)) {
            return false;
        }
        return true;
    }

    public static function detectGender($word)
    {
    	$word = S::lower($word);
    	$last = S::slice($word, -1);
		// пытаемся угадать род объекта, хотя бы примерно, чтобы правильно склонять
		if (S::slice($word, -2) == 'мя' || in_array($last, ['о', 'е', 'и', 'у']))
			return self::NEUTER;

		if (in_array($last, ['а', 'я']) ||
			($last == 'ь' && !in_array($word, self::$masculineWithSoft) && !in_array($word, self::$masculineWithSoftAndRunAwayVowels)))
			return self::FEMALE;

		return self::MALE;
    }

    public static function getDeclension($word)
    {
        $word = S::lower($word);
        $last = S::slice($word, -1);
        if (isset(self::$abnormalExceptions[$word]) || in_array($word, self::$abnormalExceptions)) {
            return 2;
        }

        if (in_array($last, ['а', 'я']) && S::slice($word, -2) != 'мя') {
            return 1;
        } elseif (self::isConsonant($last) || in_array($last, ['о', 'е', 'ё']) || ($last == 'ь' && self::isConsonant(S::slice($word, -2, -1)) && !self::isHissingConsonant(S::slice($word, -2, -1)) && (in_array($word, self::$masculineWithSoft)) || in_array($word, self::$masculineWithSoftAndRunAwayVowels))) {
            return 2;
        } else {
            return 3;
        }
    }

    public static function getCases($word, $animateness = false)
    {
        $word = S::lower($word);

        // Адъективное склонение (Сущ, образованные от прилагательных и причастий) - прохожий, существительное
        if (in_array(S::slice($word, -2), array('ой', 'ий', 'ый', 'ая', 'ое', 'ее')) && $word != 'гений') {
            return self::declinateAdjective($word, $animateness);
        }

        // Субстантивное склонение (существительные)
        if (in_array($word, self::$immutableWords)) {
            return array(
                self::IMENIT => $word,
                self::RODIT => $word,
                self::DAT => $word,
                self::VINIT => $word,
                self::TVORIT => $word,
                self::PREDLOJ => self::choosePrepositionByFirstLetter($word, 'об', 'о').' '.$word,
            );
        } elseif (isset(self::$abnormalExceptions[$word])) {
            return array_combine(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ), self::$abnormalExceptions[$word]);
        } elseif (in_array($word, self::$abnormalExceptions)) {
            $prefix = S::slice($word, 0, -1);
            return array(
                self::IMENIT => $word,
                self::RODIT => $prefix.'ени',
                self::DAT => $prefix.'ени',
                self::VINIT => $word,
                self::TVORIT => $prefix.'енем',
                self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ени',
            );
        }

        switch (self::getDeclension($word)) {
            case self::FIRST_DECLENSION:
                return self::declinateFirstDeclension($word);
            case self::SECOND_DECLENSION:
                return self::declinateSecondDeclension($word, $animateness);
            case self::THIRD_DECLENSION:
                return self::declinateThirdDeclension($word);
        }
    }

    public static function declinateFirstDeclension($word)
    {
        $word = S::lower($word);
        $prefix = S::slice($word, 0, -1);
        $last = S::slice($word, -1);
        $soft_last = self::checkLastConsonantSoftness($word);
        $forms =  array(
            Cases::IMENIT => $word,
        );

        // RODIT
        $forms[Cases::RODIT] = self::chooseVowelAfterConsonant($last, $soft_last || (in_array(S::slice($word, -2, -1), array('г', 'к', 'х'))), $prefix.'и', $prefix.'ы');

        // DAT
        $forms[Cases::DAT] = self::getPredCaseOf12Declensions($word, $last, $prefix);

        // VINIT
        $forms[Cases::VINIT] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ю', $prefix.'у');

        // TVORIT
        if ($last == 'ь') {
            $forms[Cases::TVORIT] = $prefix.'ой';
        } else {
            $forms[Cases::TVORIT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'ей', $prefix.'ой');
        }

        // 	if ($last == 'й' || (self::isConsonant($last) && !self::isHissingConsonant($last)) || self::checkLastConsonantSoftness($word))
        // 	$forms[Cases::TVORIT] = $prefix.'ей';
        // else
        // 	$forms[Cases::TVORIT] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant

        // PREDLOJ the same as DAT
        $forms[Cases::PREDLOJ] = self::choosePrepositionByFirstLetter($forms[Cases::DAT], 'об', 'о').' '.$forms[Cases::DAT];
        return $forms;
    }

    public static function declinateSecondDeclension($word, $animateness = false)
    {
        $word = S::lower($word);
        $last = S::slice($word, -1);
        $soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && ((self::isConsonant(S::slice($word, -2, -1)) && !self::isHissingConsonant(S::slice($word, -2, -1))) || S::slice($word, -2, -1) == 'и'));
        $prefix = self::getPrefixOfSecondDeclension($word, $last);
        $forms =  array(
            Cases::IMENIT => $word,
        );

        // RODIT
        $forms[Cases::RODIT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');

        // DAT
        $forms[Cases::DAT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'ю', $prefix.'у');

        // VINIT
        if (in_array($last, ['о', 'е', 'ё'])) {
            $forms[Cases::VINIT] = $word;
        } else {
            $forms[Cases::VINIT] = self::getVinitCaseByAnimateness($forms, $animateness);
        }

        // TVORIT
        // if ($last == 'ь')
        // 	$forms[Cases::TVORIT] = $prefix.'ом';
        // else if ($last == 'й' || (self::isConsonant($last) && !self::isHissingConsonant($last)))
        // 	$forms[Cases::TVORIT] = $prefix.'ем';
        // else
        // 	$forms[Cases::TVORIT] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
        if (self::isHissingConsonant($last) || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && self::isHissingConsonant(S::slice($word, -2, -1))) || $last == 'ц') {
            $forms[Cases::TVORIT] = $prefix.'ем';
        } elseif (in_array($last, ['й'/*, 'ч', 'щ'*/]) || $soft_last) {
            $forms[Cases::TVORIT] = $prefix.'ем';
        } else {
            $forms[Cases::TVORIT] = $prefix.'ом';
        }

        // PREDLOJ
        $forms[Cases::PREDLOJ] = self::getPredCaseOf12Declensions($word, $last, $prefix);
        $forms[Cases::PREDLOJ] = self::choosePrepositionByFirstLetter($forms[Cases::PREDLOJ], 'об', 'о').' '.$forms[Cases::PREDLOJ];

        return $forms;
    }

    public static function declinateThirdDeclension($word)
    {
        $word = S::lower($word);
        $prefix = S::slice($word, 0, -1);
        return array(
            Cases::IMENIT => $word,
            Cases::RODIT => $prefix.'и',
            Cases::DAT => $prefix.'и',
            Cases::VINIT => $word,
            Cases::TVORIT => $prefix.'ью',
            Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
        );
    }

    /**
     * Rules are from http://rusgram.narod.ru/1216-1231.html
     */
    public static function declinateAdjective($word, $animateness)
    {
        $prefix = S::slice($word, 0, -2);

        switch (S::slice($word, -2)) {
            // Male adjectives
            case 'ой':
            case 'ый':
                return array(
                    Cases::IMENIT => $word,
                    Cases::RODIT => $prefix.'ого',
                    Cases::DAT => $prefix.'ому',
                    Cases::VINIT => $word,
                    Cases::TVORIT => $prefix.'ым',
                    Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ом',
                );

            case 'ий':
                return array(
                    Cases::IMENIT => $word,
                    Cases::RODIT => $prefix.'его',
                    Cases::DAT => $prefix.'ему',
                    Cases::VINIT => $prefix.'его',
                    Cases::TVORIT => $prefix.'им',
                    Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ем',
                );

            // Neuter adjectives
            case 'ое':
            case 'ее':
                $prefix = S::slice($word, 0, -1);
                return array(
                    Cases::IMENIT => $word,
                    Cases::RODIT => $prefix.'го',
                    Cases::DAT => $prefix.'му',
                    Cases::VINIT => $word,
                    Cases::TVORIT => S::slice($word, 0, -2).(S::slice($word, -2, -1) == 'о' ? 'ы' : 'и').'м',
                    Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'м',
                );

            // Female adjectives
            case 'ая':
                $ending = self::isHissingConsonant(S::slice($prefix, -1)) ? 'ей' : 'ой';
                return array(
                    Cases::IMENIT => $word,
                    Cases::RODIT => $prefix.$ending,
                    Cases::DAT => $prefix.$ending,
                    Cases::VINIT => $prefix.'ую',
                    Cases::TVORIT => $prefix.$ending,
                    Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.$ending,
                );
        }
    }

    public static function getCase($word, $case, $animateness = false)
    {
        $case = self::canonizeCase($case);
        $forms = self::getCases($word, $animateness);
        return $forms[$case];
    }

    public static function getPrefixOfSecondDeclension($word, $last)
    {
        // слова с бегающей гласной в корне
        if (in_array($word, self::$masculineWithSoftAndRunAwayVowels)) {
            $prefix = S::slice($word, 0, -3).S::slice($word, -2, -1);
        } elseif (in_array($last, ['о', 'е', 'ё', 'ь', 'й'])) {
            $prefix = S::slice($word, 0, -1);
        }
        // уменьшительные формы слов (котенок) и слова с суффиксом ок
        elseif (S::slice($word, -2) == 'ок' && S::length($word) > 3) {
            $prefix = S::slice($word, 0, -2).'к';
        } else {
            $prefix = $word;
        }
        return $prefix;
    }

    public static function getVinitCaseByAnimateness(array $forms, $animate)
    {
        if ($animate) {
            return $forms[Cases::RODIT];
        } else {
            return $forms[Cases::IMENIT];
        }
    }

    public static function getPredCaseOf12Declensions($word, $last, $prefix)
    {
        if (in_array(S::slice($word, -2), array('ий', 'ие'))) {
            if ($last == 'ё') {
                return $prefix.'е';
            } else {
                return $prefix.'и';
            }
        } else {
            return $prefix.'е';
        }
    }
}
