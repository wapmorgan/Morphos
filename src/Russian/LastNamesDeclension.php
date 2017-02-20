<?php
namespace morphos\Russian;

/**
 * Rules are from http://gramma.ru/SPR/?id=2.8
 */
class LastNamesDeclension extends \morphos\NamesDeclension implements Cases {
    use RussianLanguage, CasesHelper;

    static protected $menPostfixes = array('ов', 'ев' ,'ин' ,'ын', 'ой', 'ий');
    static protected $womenPostfixes = array('ва', 'на', 'ая', 'яя');

    public function hasForms($name, $gender) {
        $name = lower($name);

        if (in_array(slice($name, -1), array('а', 'я')))
            return true;

        if ($gender == self::MAN) {
            if (in_array(slice($name, -2), array('ов', 'ев', 'ин', 'ын', 'ий', 'ой')))
                return true;
            if (in_array(upper(slice($name, -1)), RussianLanguage::$consonants))
                return true;

            if (slice($name, -1) == 'ь')
                return true;
        } else {
            if (in_array(slice($name, -2), array('ва', 'на')) || in_array(slice($name, -4), array('ская')))
                return true;
        }

        return false;
    }

    public function detectGender($name) {
        $name = lower($name);
        if (in_array(slice($name, -2), self::$menPostfixes))
            return self::MAN;
        if (in_array(slice($name, -2), self::$womenPostfixes))
            return self::WOMAN;

        return null;
    }

    public function getForms($name, $gender) {
        $name = lower($name);
        if ($gender == self::MAN) {
            if (in_array(slice($name, -2), array('ов', 'ев', 'ин', 'ын'))) {
                $prefix = name($name);
                return array(
                    self::IMENIT => $prefix,
                    self::RODIT => $prefix.'а',
                    self::DAT => $prefix.'у',
                    self::VINIT => $prefix.'а',
                    self::TVORIT => $prefix.'ым',
                    self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
                );
            }
            else if (in_array(slice($name, -4), array('ский', 'ской', 'цкий', 'цкой'))) {
                $prefix = name(slice($name, 0, -2));
                return array(
                    self::IMENIT => name($name),
                    self::RODIT => $prefix.'ого',
                    self::DAT => $prefix.'ому',
                    self::VINIT => $prefix.'ого',
                    self::TVORIT => $prefix.'им',
                    self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ом'
                );
            }
        } else {
            if (in_array(slice($name, -3), array('ова', 'ева', 'ина', 'ына'))) {
                $prefix = name(slice($name, 0, -1));
                return array(
                    self::IMENIT => name($name),
                    self::RODIT => $prefix.'ой',
                    self::DAT => $prefix.'ой',
                    self::VINIT => $prefix.'у',
                    self::TVORIT => $prefix.'ой',
                    self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой'
                );
            }

            if (in_array(slice($name, -4), array('ская'))) {
                $prefix = name(slice($name, 0, -2));
                return array(
                    self::IMENIT => name($name),
                    self::RODIT => $prefix.'ой',
                    self::DAT => $prefix.'ой',
                    self::VINIT => $prefix.'ую',
                    self::TVORIT => $prefix.'ой',
                    self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой'
                );
            }
        }

        if (slice($name, -1) == 'я') {
            $prefix = name(slice($name, 0, -1));
            return array(
                self::IMENIT => name($name),
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'ю',
                self::TVORIT => $prefix.'ей',
                self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (slice($name, -1) == 'а') {
            $prefix = name(slice($name, 0, -1));
            return array(
                self::IMENIT => name($name),
                self::RODIT => $prefix.'ы',
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'у',
                self::TVORIT => $prefix.'ой',
                self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (in_array(upper(slice($name, -1)), RussianLanguage::$consonants)) {
            $prefix = name($name);
            return array(
                self::IMENIT => name($name),
                self::RODIT => $prefix.'а',
                self::DAT => $prefix.'у',
                self::VINIT => $prefix.'а',
                self::TVORIT => $prefix.'ом',
                self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (slice($name, -1) == 'ь') {
            $prefix = name(slice($name, 0, -1));
            return array(
                self::IMENIT => name($name),
                self::RODIT => $prefix.'я',
                self::DAT => $prefix.'ю',
                self::VINIT => $prefix.'я',
                self::TVORIT => $prefix.'ем',
                self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        }

        $name = name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT), $name) + array(self::PREDLOJ => $this->choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name);
    }

    public function getForm($name, $case, $gender) {
        $case = self::canonizeCase($case);
        $forms = $this->getForms($name, $gender);
        if ($forms !== false)
            if (isset($forms[$case]))
                return $forms[$case];
            else
                return $name;
        else
            return $name;
    }
}
