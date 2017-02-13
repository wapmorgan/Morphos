<?php
namespace morphos\Russian;

/**
 * Rules are from http://gramma.ru/SPR/?id=2.8
 */
class LastNamesDeclension extends \morphos\NamesDeclension implements Cases {
    use RussianLanguage;

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
                    self::IMENIT_1 => $prefix,
                    self::RODIT_2 => $prefix.'а',
                    self::DAT_3 => $prefix.'у',
                    self::VINIT_4 => $prefix.'а',
                    self::TVORIT_5 => $prefix.'ым',
                    self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
                );
            }

            if (in_array(slice($name, -4), array('ский', 'ской', 'цкий', 'цкой'))) {
                $prefix = name(slice($name, 0, -2));
                return array(
                    self::IMENIT_1 => name($name),
                    self::RODIT_2 => $prefix.'ого',
                    self::DAT_3 => $prefix.'ому',
                    self::VINIT_4 => $prefix.'ого',
                    self::TVORIT_5 => $prefix.'им',
                    self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ом'
                );
            }
        } else {
            if (in_array(slice($name, -3), array('ова', 'ева', 'ина', 'ына'))) {
                $prefix = name(slice($name, 0, -1));
                return array(
                    self::IMENIT_1 => name($name),
                    self::RODIT_2 => $prefix.'ой',
                    self::DAT_3 => $prefix.'ой',
                    self::VINIT_4 => $prefix.'у',
                    self::TVORIT_5 => $prefix.'ой',
                    self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой'
                );
            }

            if (in_array(slice($name, -4), array('ская'))) {
                $prefix = name(slice($name, 0, -2));
                return array(
                    self::IMENIT_1 => name($name),
                    self::RODIT_2 => $prefix.'ой',
                    self::DAT_3 => $prefix.'ой',
                    self::VINIT_4 => $prefix.'ую',
                    self::TVORIT_5 => $prefix.'ой',
                    self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой'
                );
            }
        }

        if (slice($name, -1) == 'я') {
            $prefix = name(slice($name, 0, -1));
            return array(
                self::IMENIT_1 => name($name),
                self::RODIT_2 => $prefix.'и',
                self::DAT_3 => $prefix.'е',
                self::VINIT_4 => $prefix.'ю',
                self::TVORIT_5 => $prefix.'ей',
                self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (slice($name, -1) == 'а') {
            $prefix = name(slice($name, 0, -1));
            return array(
                self::IMENIT_1 => name($name),
                self::RODIT_2 => $prefix.'ы',
                self::DAT_3 => $prefix.'е',
                self::VINIT_4 => $prefix.'у',
                self::TVORIT_5 => $prefix.'ой',
                self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (in_array(upper(slice($name, -1)), RussianLanguage::$consonants)) {
            $prefix = name($name);
            return array(
                self::IMENIT_1 => name($name),
                self::RODIT_2 => $prefix.'а',
                self::DAT_3 => $prefix.'у',
                self::VINIT_4 => $prefix.'а',
                self::TVORIT_5 => $prefix.'ом',
                self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        } else if (slice($name, -1) == 'ь') {
            $prefix = name(slice($name, 0, -1));
            return array(
                self::IMENIT_1 => name($name),
                self::RODIT_2 => $prefix.'я',
                self::DAT_3 => $prefix.'ю',
                self::VINIT_4 => $prefix.'я',
                self::TVORIT_5 => $prefix.'ем',
                self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е'
            );
        }

        $name = name($name);
        return array_fill_keys(array(self::IMENIT_1, self::RODIT_2, self::DAT_3, self::VINIT_4, self::TVORIT_5), $name) + array(self::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name);
    }

    public function getForm($name, $form, $gender) {
        $forms = $this->getForms($name, $gender);
        if ($forms !== false)
            if (isset($forms[$form]))
                return $forms[$form];
            else
                return $name;
        else
            return $name;
    }
}
