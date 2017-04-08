<?php
namespace morphos\Russian;

use morphos\S;

function name($fullname, $case = null, $gender = null) {
    if (in_array($case, array('m', 'w'))) {
        $gender = $case;
        $case = null;
    }
    if ($gender === null) $gender = detectGender($fullname);

    $name = explode(' ', $fullname);
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

function detectGender($fullname) {
    static $first, $middle, $last;
    $name = explode(' ', S::lower($fullname));

    return (isset($name[2]) ? MiddleNamesDeclension::detectGender($name[2]) : null) ?:
        FirstNamesDeclension::detectGender($name[1]) ?:
        LastNamesDeclension::detectGender($name[0]);
}

function pluralize($word, $count = 2, $animateness = false) {
    return Plurality::pluralize($word, $count, $animateness);
}
