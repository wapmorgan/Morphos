<?php
namespace morphos\Russian;

/**
 * Rules are from http://surnameonline.ru/patronymic.html
 */
class MiddleNamesDeclension extends \morphos\NamesDeclension implements Cases {
    use RussianLanguage, CasesHelper;

    public function detectGender($name) {
        $name = lower($name);
        if (slice($name, -2) == 'ич')
            return self::MAN;
        else if (slice($name, -2) == 'на')
            return self::WOMAN;

        return null;
    }

    public function isMutable($name, $gender) {
        $name = lower($name);
        if (in_array(slice($name, -2), array('ич', 'на')))
            return true;
        return false;
    }

    public function getCase($name, $case, $gender) {
        $case = self::canonizeCase($case);
        $forms = $this->getCases($name, $gender);
        return $forms[$case];
    }

    public function getCases($name, $gender) {
        $name = lower($name);
        if (slice($name, -2) == 'ич') {
            // man rules
            $name = name($name);
            return array(
                Cases::IMENIT => $name,
                Cases::RODIT => $name.'а',
                Cases::DAT => $name.'у',
                Cases::VINIT => $name.'а',
                Cases::TVORIT => $name.'ем',
                Cases::PREDLOJ => $this->choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name.'е',
            );
        } else if (slice($name, -2) == 'на') {
            $prefix = name(slice($name, 0, -1));
            return array(
                Cases::IMENIT => $prefix.'а',
                Cases::RODIT => $prefix.'ы',
                Cases::DAT => $prefix.'е',
                Cases::VINIT => $prefix.'у',
                Cases::TVORIT => $prefix.'ой',
                Cases::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
            );
        }

        // immutable middle name
        $name = name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT), $name) + array(self::PREDLOJ => $this->choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name);
    }
}
