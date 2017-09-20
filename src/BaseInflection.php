<?php
namespace morphos;

abstract class BaseInflection implements Cases
{
    public static function isMutable($name)
    {
    }

    public static function getCases($name)
    {
    }

    public static function getCase($name, $case)
    {
    }

    /**
     * Составляет один массив с падежами из нескольких массивов падежей разных слов
     * @param array $words Двумерный массив слов и их падежей
     * @param string $delimiter Разделитель между падежами слов
     * @return array Одномерный массив падежей
     */
    public static function composeCasesFromWords(array $words, $delimiter = ' ') {
        $cases = [];
        foreach (CasesHelper::getAllCases() as $case) {
            $composed_case = [];
            foreach ($words as $wordCases) {
                $composed_case[] = $wordCases[$case];
            }
            $cases[$case] = implode($delimiter, $composed_case);
        }
        return $cases;
    }
}
