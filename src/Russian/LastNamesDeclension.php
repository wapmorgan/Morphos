<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://gramma.ru/SPR/?id=2.8
 */
class LastNamesDeclension extends \morphos\NamesDeclension implements Cases {
    use RussianLanguage, CasesHelper;

    static protected $menPostfixes = array('ов', 'ев' ,'ин' ,'ын', 'ой', 'ий');
    static protected $womenPostfixes = array('ва', 'на', 'ая', 'яя');

    static public function isMutable($name, $gender = null) {
        $name = S::lower($name);
        if ($gender === null) $gender = self::detectGender($name);

        if (in_array(S::slice($name, -1), array('а', 'я')))
            return true;

        if ($gender == self::MALE) {
            if (in_array(S::slice($name, -2), array('ов', 'ев', 'ин', 'ын', 'ий', 'ой')))
                return true;
            if (in_array(S::upper(S::slice($name, -1)), RussianLanguage::$consonants))
                return true;

            if (S::slice($name, -1) == 'ь')
                return true;
        } else {
            if (in_array(S::slice($name, -2), array('ва', 'на')) || in_array(S::slice($name, -4), array('ская')))
                return true;
        }

        return false;
    }

    static public function detectGender($name) {
        $name = S::lower($name);
        if (in_array(S::slice($name, -2), self::$menPostfixes))
            return self::MALE;
        if (in_array(S::slice($name, -2), self::$womenPostfixes))
            return self::FEMALE;

        return null;
    }

    static public function getCases($name, $gender = null) {
        $name = S::lower($name);
        if ($gender === null) $gender = self::detectGender($name);
        if ($gender == self::MALE) {
            if (in_array(S::slice($name, -2), array('ов', 'ев', 'ин', 'ын'))) {
                $prefix = S::name($name);
                return array(
                    self::IMENIT => $prefix,
                    self::RODIT => $prefix.'а',
                    self::DAT => $prefix.'у',
                    self::VINIT => $prefix.'а',
                    self::TVORIT => $prefix.'ым',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
                );
            }
            else if (in_array(S::slice($name, -4), array('ский', 'ской', 'цкий', 'цкой'))) {
                $prefix = S::name(S::slice($name, 0, -2));
                return array(
                    self::IMENIT => S::name($name),
                    self::RODIT => $prefix.'ого',
                    self::DAT => $prefix.'ому',
                    self::VINIT => $prefix.'ого',
                    self::TVORIT => $prefix.'им',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ом'
                );
            }
        } else {
            if (in_array(S::slice($name, -3), array('ова', 'ева', 'ина', 'ына'))) {
                $prefix = S::name(S::slice($name, 0, -1));
                return array(
                    self::IMENIT => S::name($name),
                    self::RODIT => $prefix.'ой',
                    self::DAT => $prefix.'ой',
                    self::VINIT => $prefix.'у',
                    self::TVORIT => $prefix.'ой',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой'
                );
            }

            if (in_array(S::slice($name, -4), array('ская'))) {
                $prefix = S::name(S::slice($name, 0, -2));
                return array(
                    self::IMENIT => S::name($name),
                    self::RODIT => $prefix.'ой',
                    self::DAT => $prefix.'ой',
                    self::VINIT => $prefix.'ую',
                    self::TVORIT => $prefix.'ой',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой'
                );
            }
        }

        if (S::slice($name, -1) == 'я') {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => S::name($name),
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'ю',
                self::TVORIT => $prefix.'ей',
                self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (S::slice($name, -1) == 'а') {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => S::name($name),
                self::RODIT => $prefix.'ы',
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'у',
                self::TVORIT => $prefix.'ой',
                self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (in_array(S::upper(S::slice($name, -1)), RussianLanguage::$consonants)) {
            $prefix = S::name($name);
            return array(
                self::IMENIT => S::name($name),
                self::RODIT => $prefix.'а',
                self::DAT => $prefix.'у',
                self::VINIT => $prefix.'а',
                self::TVORIT => $prefix.'ом',
                self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (S::slice($name, -1) == 'ь') {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => S::name($name),
                self::RODIT => $prefix.'я',
                self::DAT => $prefix.'ю',
                self::VINIT => $prefix.'я',
                self::TVORIT => $prefix.'ем',
                self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        }

        $name = S::name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT), $name) + array(self::PREDLOJ => self::choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name);
    }

    static public function getCase($name, $case, $gender = null) {
        $case = self::canonizeCase($case);
        $forms = self::getCases($name, $gender);
        return $forms[$case];
    }
}
