<?php
namespace morphos\Russian;

/**
 * Rules are from http://surnameonline.ru/patronymic.html
 */
class MiddleNamesDeclension extends \morphos\NamesDeclension implements Cases {
    use RussianLanguage;

    public function getForm($name, $form, $gender) {
        $forms = $this->getForms($name, $gender);
        return $forms[$form];
    }

    public function getForms($name, $gender) {
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
            $prefix = name(slice($name, -1));
            return array(
                Cases::IMENIT => $prefix.'а',
                Cases::RODIT => $prefix.'ы',
                Cases::DAT => $prefix.'е',
                Cases::VINIT => $prefix.'у',
                Cases::TVORIT => $prefix.'ой',
                Cases::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$name.'е',
            );
        } else {
            return false;
        }
    }
}
