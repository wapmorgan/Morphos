<?php

namespace morphos\Russian;

use morphos\Gender;
use morphos\S;

/**
 * Inflects the name in one case.
 * @param string $fullName        Name in "F", "L F" or "L M F" format, where L - last name, M - middle name, F - first name
 * @param string $case            Case to inflect to.
 *                                Should be one of [[morphos\Cases]] or [[morphos\Russian\Cases]] constants.
 * @param null|string $gender     Gender of name owner. If null, auto detection will be used.
 *                                Should be one of [[morphos\Gender]] constants.
 * @return string|false           Returns string containing the inflection of name to a case.
 * @throws \Exception
 */
function inflectName($fullName, $case = null, $gender = null)
{
    if (in_array($case, [Gender::MALE, Gender::FEMALE, null], true)) {
        return $case === null ? getNameCases($fullName) : getNameCases($fullName, $case);
    }

    $fullName = normalizeFullName($fullName);
    $case     = RussianCasesHelper::canonizeCase($case);
    if ($gender === null) {
        $gender = detectGender($fullName);
    }

    $name = explode(' ', $fullName);

    switch (count($name)) {
        case 1:
            $name[0] = FirstNamesInflection::getCase($name[0], $case, $gender);
            break;

        case 2:
            $name[0] = LastNamesInflection::getCase($name[0], $case, $gender);
            $name[1] = FirstNamesInflection::getCase($name[1], $case, $gender);
            break;

        case 3:
            $name[0] = LastNamesInflection::getCase($name[0], $case, $gender);
            $name[1] = FirstNamesInflection::getCase($name[1], $case, $gender);
            $name[2] = MiddleNamesInflection::getCase($name[2], $case, $gender);
            break;

        default:
            return false;
    }

    return implode(' ', $name);
}

/**
 * Inflects the name to all cases.
 * @param string $fullName      Name in "F", "L F" or "L M F" format, where L - last name, M - middle name, F - first name
 * @param null|string $gender   Gender of name owner. If null, auto detection will be used.
 *                              Should be one of [[morphos\Gender]] constants.
 * @return string[]|false          Returns an array with name inflected to all cases.
 */
function getNameCases($fullName, $gender = null)
{
    $fullName = normalizeFullName($fullName);
    if ($gender === null) {
        $gender = detectGender($fullName);
    }

    $name = explode(' ', $fullName);

    switch (count($name)) {
        case 1:
            $name[0] = FirstNamesInflection::getCases($name[0], $gender);
            break;

        case 2:
            $name[0] = LastNamesInflection::getCases($name[0], $gender);
            $name[1] = FirstNamesInflection::getCases($name[1], $gender);
            break;

        case 3:
            $name[0] = LastNamesInflection::getCases($name[0], $gender);
            $name[1] = FirstNamesInflection::getCases($name[1], $gender);
            $name[2] = MiddleNamesInflection::getCases($name[2], $gender);
            break;

        default:
            return false;
    }

    return RussianCasesHelper::composeCasesFromWords($name);
}

/**
 * Guesses the gender of name owner.
 * @param string $fullName Name in "F", "L F" or "L M F" format, where L - last name, M - middle name, F - first name
 * @return null|string     Null if not detected. One of [[morphos\Gender]] constants.
 */
function detectGender($fullName)
{
    $gender    = null;
    $name      = explode(' ', S::lower($fullName));
    $nameCount = count($name);
    if ($nameCount > 3) {
        return null;
    }

    if ($nameCount === 1) {
        return FirstNamesInflection::detectGender($name[0]);
    } else {
        if ($nameCount === 2) {
            return LastNamesInflection::detectGender($name[0])
                ?: FirstNamesInflection::detectGender($name[1]);
        } else {
            return MiddleNamesInflection::detectGender($name[2])
                ?: (LastNamesInflection::detectGender($name[0])
                    ?: FirstNamesInflection::detectGender($name[1]));
        }
    }
}

/**
 * Normalizes a full name. Swaps name parts to make "L F" or "L M F" scheme.
 * @param string $name Input name
 * @return string      Normalized name
 */
function normalizeFullName($name)
{
    $name = preg_replace('~[ ]{2,}~', '', trim($name));
    return $name;
}

/**
 * Генерация строки с числом и существительным, в правильной форме для сочетания с числом (кол-вом предметов).
 *
 * @param int $count          Количество предметов
 * @param string $word        Название предмета ИЛИ "прилагатально предмет". Может включать в себя несколько
 *                            прилагательных перед существительным.
 *                            Например: "сообщение", "новое сообщение", "небольшая лампа".
 * @param bool $animateness   Признак одушевленности
 * @param string $case        Род существительного (по умолчанию именительный для 1 предмета и родительный для
 *                            нескольких)
 *
 * @return string Строка в формате "ЧИСЛО [СУЩ в правильной форме]"
 * @throws \Exception
 */
function pluralize($count, $word, $animateness = false, $case = null)
{
    // меняем местами аргументы, если они переданы в старом формате
    // @phpstan-ignore-next-line
    if (is_string($count) && is_numeric($word)) {
        list($count, $word) = [$word, $count];
    }

    if (strpos($word, ' ') !== false) {
        $words = explode(' ', $word);
        $noun  = array_pop($words);

        foreach ($words as $i => $word) {
            if (in_array($word, RussianLanguage::$unions, true)) {
                $words[$i] = $word;
            } else {
                $words[$i] = AdjectivePluralization::pluralize($word, $count, $animateness, $case);
            }
        }

        return $count . ' ' . implode(' ', $words) . ' ' . NounPluralization::pluralize($count, $noun, $animateness,
                $case);
    }

    return $count . ' ' . NounPluralization::pluralize($word, $count, $animateness, $case);
}
