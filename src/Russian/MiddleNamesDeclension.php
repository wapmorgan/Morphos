<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://surnameonline.ru/patronymic.html
 */
class MiddleNamesDeclension extends \morphos\NamesDeclension implements Cases {
    use RussianLanguage, CasesHelper;

    static public function detectGender($name) {
        $name = S::lower($name);
        if (S::slice($name, -2) == 'ич')
            return self::MALE;
        else if (S::slice($name, -2) == 'на')
            return self::FEMALE;

        return null;
    }

    static public function isMutable($name, $gender = null) {
        $name = S::lower($name);
        if (in_array(S::slice($name, -2), array('ич', 'на')))
            return true;
        return false;
    }

    static public function getCase($name, $case, $gender = null) {
        $case = self::canonizeCase($case);
        $forms = self::getCases($name, $gender);
        return $forms[$case];
    }

    static public function getCases($name, $gender = null) {
        $name = S::lower($name);
        if (S::slice($name, -2) == 'ич') {
            // man rules
            $name = S::name($name);
            return array(
                Cases::IMENIT => $name,
                Cases::RODIT => $name.'а',
                Cases::DAT => $name.'у',
                Cases::VINIT => $name.'а',
                Cases::TVORIT => $name.'ем',
                Cases::PREDLOJ => self::choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name.'е',
            );
        } else if (S::slice($name, -2) == 'на') {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                Cases::IMENIT => $prefix.'а',
                Cases::RODIT => $prefix.'ы',
                Cases::DAT => $prefix.'е',
                Cases::VINIT => $prefix.'у',
                Cases::TVORIT => $prefix.'ой',
                Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
            );
        }

        // immutable middle name
        $name = S::name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT), $name) + array(self::PREDLOJ => self::choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name);
    }
}
