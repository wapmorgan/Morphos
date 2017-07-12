<?php
namespace morphos\Russian;

use morphos\S;

function name($fullname, $case = null, $gender = null)
{
    if (in_array($case, array('m', 'f'))) {
        $gender = $case;
        $case = null;
    }
    if ($gender === null) $gender = detectGender($fullname);

    $name = explode(' ', $fullname);
    if (count($name) < 2 || count($name) > 3)
        return false;
    if ($case === null) {
        $result = array();
        if (count($name) == 2) {
            $name[0] = LastNamesDeclension::getCases($name[0], $gender);
            $name[1] = FirstNamesDeclension::getCases($name[1], $gender);
        } else if (count($name) == 3) {
            $name[0] = LastNamesDeclension::getCases($name[0], $gender);
            $name[1] = FirstNamesDeclension::getCases($name[1], $gender);
            $name[2] = MiddleNamesDeclension::getCases($name[2], $gender);
        }
        foreach (array(Cases::IMENIT, Cases::RODIT, Cases::DAT, Cases::VINIT, Cases::TVORIT, Cases::PREDLOJ) as $case) {
            foreach ($name as $partNum => $namePart) {
                if ($case == Cases::PREDLOJ && $partNum > 0) list(, $namePart[$case]) = explode(' ', $namePart[$case]);
                $result[$case][] = $namePart[$case];
            }
            $result[$case] = implode(' ', $result[$case]);
        }
        return $result;
    } else {
        $case = CasesHelper::canonizeCase($case);
        if (count($name) == 2) {
            $name[0] = LastNamesDeclension::getCase($name[0], $case, $gender);
            $name[1] = FirstNamesDeclension::getCase($name[1], $case, $gender);
            if ($case == Cases::PREDLOJ) list(, $name[1]) = explode(' ', $name[1]);
        } else if (count($name) == 3) {
            $name[0] = LastNamesDeclension::getCase($name[0], $case, $gender);
            $name[1] = FirstNamesDeclension::getCase($name[1], $case, $gender);
            if ($case == Cases::PREDLOJ) list(, $name[1]) = explode(' ', $name[1]);
            $name[2] = MiddleNamesDeclension::getCase($name[2], $case, $gender);
            if ($case == Cases::PREDLOJ) list(, $name[2]) = explode(' ', $name[2]);
        }
    }
    return implode(' ', $name);
}

function detectGender($fullname)
{
    static $first, $middle, $last;
    $name = explode(' ', S::lower($fullname));
    if (count($name) < 2 || count($name) > 3)
        return false;

    return (isset($name[2]) ? MiddleNamesDeclension::detectGender($name[2]) : null) ?:
        FirstNamesDeclension::detectGender($name[1]) ?:
        LastNamesDeclension::detectGender($name[0]);
}

function pluralize($word, $count = 2, $animateness = false)
{
    return Plurality::pluralize($word, $count, $animateness);
}

/**
 * @param string $verb Verb to modificate if gender is female
 * @param string $gender If not `m`, verb will be modificated
 * @return string Correct verb
 */
function verb($verb, $gender)
{
    // возвратный глагол
    if (S::slice($verb, -2) == 'ся')
        return ($gender == 'm' ? $verb : mb_substr($verb, 0, -2).'ась');

    // обычный глагол
    return ($gender == 'm' ? $verb : $verb.'а');
}
