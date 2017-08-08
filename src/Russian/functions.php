<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Inflects the name to all cases / one case.
 * @param string      $fullname Name in format: "L F" o "L M F", where L - last name, M - middl name, F - first name
 * @param null|string $case     Case to inflect to. If null, result will contain inflection to all cases.
 *                              Should be one of {@link morphos\Cases} or {@link morphos\Russian\Cases} constants.
 * @param null|tring  $gender   Gender of name owner. If null, auto detection will be used.
 *                              Should be one of {@link morphos\Gender} constants.
 * @return string|array         Returns string containing the inflection of name to a case, if `$case` is not null.
 *                              Returns an array will inflection to all cases.
 */
function inflectName($fullname, $case = null, $gender = null)
{
    if (in_array($case, array('m', 'f'))) {
        $gender = $case;
        $case = null;
    }
    if ($gender === null) $gender = detectGender($fullname);
    $fullname = normalizeFullName($fullname);

    $name = explode(' ', $fullname);
    if (count($name) < 2 || count($name) > 3) {
        return false;
    }
    if ($case === null) {
        $result = array();
        if (count($name) == 2) {
            $name[0] = LastNamesInflection::getCases($name[0], $gender);
            $name[1] = FirstNamesInflection::getCases($name[1], $gender);
        } elseif (count($name) == 3) {
            $name[0] = LastNamesInflection::getCases($name[0], $gender);
            $name[1] = FirstNamesInflection::getCases($name[1], $gender);
            $name[2] = MiddleNamesInflection::getCases($name[2], $gender);
        }
        foreach (array(Cases::IMENIT, Cases::RODIT, Cases::DAT, Cases::VINIT, Cases::TVORIT, Cases::PREDLOJ) as $case) {
            foreach ($name as $partNum => $namePart) {
                if ($case == Cases::PREDLOJ && $partNum > 0) {
                    list(, $namePart[$case]) = explode(' ', $namePart[$case]);
                }
                $result[$case][] = $namePart[$case];
            }
            $result[$case] = implode(' ', $result[$case]);
        }
        return $result;
    } else {
        $case = CasesHelper::canonizeCase($case);
        if (count($name) == 2) {
            $name[0] = LastNamesInflection::getCase($name[0], $case, $gender);
            $name[1] = FirstNamesInflection::getCase($name[1], $case, $gender);
            if ($case == Cases::PREDLOJ) {
                list(, $name[1]) = explode(' ', $name[1]);
            }
        } elseif (count($name) == 3) {
            $name[0] = LastNamesInflection::getCase($name[0], $case, $gender);
            $name[1] = FirstNamesInflection::getCase($name[1], $case, $gender);
            if ($case == Cases::PREDLOJ) {
                list(, $name[1]) = explode(' ', $name[1]);
            }
            $name[2] = MiddleNamesInflection::getCase($name[2], $case, $gender);
            if ($case == Cases::PREDLOJ) {
                list(, $name[2]) = explode(' ', $name[2]);
            }
        }
    }
    return implode(' ', $name);
}

/**
 * Guesses the gender of name owner.
 * @param string $fullname
 * @return null|string     Null if not detected. One of {@link morphos\Gender} constants.
 */
function detectGender($fullname)
{
    static $first, $middle, $last;
    $name = explode(' ', S::lower($fullname));
    if (count($name) < 2 || count($name) > 3) {
        return false;
    }

    return (isset($name[2]) ? MiddleNamesInflection::detectGender($name[2]) : null) ?:
        LastNamesInflection::detectGender($name[0]) ?:
        FirstNamesInflection::detectGender($name[1]);
}

/**
 * Normalizes a full name. Swaps name parts to make "L F" or "L M F" scheme.
 * @param string $name Input name
 * @return string      Normalized name
 */
function normalizeFullName($name)
{
    $name = preg_replace('~[ ]{2,}~', null, trim($name));
    return $name;
}

/*
 * @param string $word
 * @param int $count
 * @param bool $animateness
 * @return string
 */
function pluralize($count, $word, $animateness = false)
{
    return $count.' '.NounPluralization::pluralize($word, $count, $animateness);
}

/**
 * @param string $verb Verb to modify if gender is female
 * @param string $gender If not `m`, verb will be modified
 * @return string Correct verb
 */
function verb($verb, $gender)
{
    // возвратный глагол
    if (S::slice($verb, -2) == 'ся') {
        return ($gender == 'm' ? $verb : mb_substr($verb, 0, -2).'ась');
    }

    // обычный глагол
    return ($gender == 'm' ? $verb : $verb.'а');
}
