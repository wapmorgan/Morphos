<?php

namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://surnameonline.ru/patronymic.html
 */
class MiddleNamesInflection extends \morphos\NamesInflection implements Cases
{
    /**
     * @param string $name
     * @return null|string
     */
    public static function detectGender($name)
    {
        $name = S::lower($name);
        if (S::slice($name, -2) == 'ич') {
            return static::MALE;
        } elseif (S::slice($name, -2) == 'на') {
            return static::FEMALE;
        }

        return null;
    }

    /**
     * @param string $name
     * @param null $gender
     * @return bool
     */
    public static function isMutable($name, $gender = null)
    {
        if (S::length($name) === 1) {
            return false;
        }

        $name = S::lower($name);

        if (in_array(S::slice($name, -2), ['ич', 'на'], true)) {
            return true;
        }

        // it's foreign middle name, inflect it as a first name
        return FirstNamesInflection::isMutable($name, $gender);
    }

    /**
     * @param string $name
     * @param string $case
     * @param string|null $gender
     * @return string
     * @throws \Exception
     */
    public static function getCase($name, $case, $gender = null)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($name, $gender);
        return $forms[$case];
    }

    /**
     * @param string $name
     * @param string|null $gender
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($name, $gender = null)
    {
        $name = S::lower($name);
        if (S::slice($name, -2) == 'ич') {
            // man rules
            $name = S::name($name);
            return [
                Cases::IMENIT  => $name,
                Cases::RODIT   => $name . 'а',
                Cases::DAT     => $name . 'у',
                Cases::VINIT   => $name . 'а',
                Cases::TVORIT  => $name . 'ем',
                Cases::PREDLOJ => $name . 'е',
            ];
        } elseif (S::slice($name, -2) == 'на') {
            $prefix = S::name(S::slice($name, 0, -1));
            return [
                Cases::IMENIT  => $prefix . 'а',
                Cases::RODIT   => $prefix . 'ы',
                Cases::DAT     => $prefix . 'е',
                Cases::VINIT   => $prefix . 'у',
                Cases::TVORIT  => $prefix . 'ой',
                Cases::PREDLOJ => $prefix . 'е',
            ];
        }

        // inflect other middle names (foreign) as first names
        return FirstNamesInflection::getCases($name, $gender);
    }
}
