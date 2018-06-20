<?php
namespace morphos\Russian;

use morphos\NumeralGenerator;
use morphos\S;

/**
 * Rules are from http://www.fio.ru/pravila/grammatika/sklonenie-imen-chislitelnykh/
 */
class CardinalNumeralGenerator extends NumeralGenerator implements Cases
{
    use RussianLanguage, CasesHelper;

    protected static $words = [
        1 => 'один',
        2 => 'два',
        3 => 'три',
        4 => 'четыре',
        5 => 'пять',
        6 => 'шесть',
        7 => 'семь',
        8 => 'восемь',
        9 => 'девять',
        10 => 'десять',
        11 => 'одиннадцать',
        12 => 'двенадцать',
        13 => 'тринадцать',
        14 => 'четырнадцать',
        15 => 'пятнадцать',
        16 => 'шестнадцать',
        17 => 'семнадцать',
        18 => 'восемнадцать',
        19 => 'девятнадцать',
        20 => 'двадцать',
        30 => 'тридцать',
        40 => 'сорок',
        50 => 'пятьдесят',
        60 => 'шестьдесят',
        70 => 'семьдесят',
        80 => 'восемьдесят',
        90 => 'девяносто',
        100 => 'сто',
        200 => 'двести',
        300 => 'триста',
        400 => 'четыреста',
        500 => 'пятьсот',
        600 => 'шестьсот',
        700 => 'семьсот',
        800 => 'восемьсот',
        900 => 'девятьсот',
    ];

    protected static $exponents = [
        '1000' => 'тысяча',
        '1000000' => 'миллион',
        '1000000000' => 'миллиард',
        '1000000000000' => 'триллион',
        '1000000000000000' => 'квадриллион',
    ];

    protected static $precalculated = [
        'один' => [
            self::MALE => [
                self::IMENIT => 'один',
                self::RODIT => 'одного',
                self::DAT => 'одному',
                self::VINIT => 'один',
                self::TVORIT => 'одним',
                self::PREDLOJ => 'одном',
            ],
            self::FEMALE => [
                self::IMENIT => 'одна',
                self::RODIT => 'одной',
                self::DAT => 'одной',
                self::VINIT => 'одну',
                self::TVORIT => 'одной',
                self::PREDLOJ => 'одной',
            ],
            self::NEUTER => [
                self::IMENIT => 'одно',
                self::RODIT => 'одного',
                self::DAT => 'одному',
                self::VINIT => 'одно',
                self::TVORIT => 'одним',
                self::PREDLOJ => 'одном',
            ],
        ],
        'два' => [
            self::MALE => [
                self::IMENIT => 'два',
                self::RODIT => 'двух',
                self::DAT => 'двум',
                self::VINIT => 'два',
                self::TVORIT => 'двумя',
                self::PREDLOJ => 'двух',
            ],
            self::FEMALE => [
                self::IMENIT => 'две',
                self::RODIT => 'двух',
                self::DAT => 'двум',
                self::VINIT => 'две',
                self::TVORIT => 'двумя',
                self::PREDLOJ => 'двух',
            ],
            self::NEUTER => [
                self::IMENIT => 'два',
                self::RODIT => 'двух',
                self::DAT => 'двум',
                self::VINIT => 'два',
                self::TVORIT => 'двумя',
                self::PREDLOJ => 'двух',
            ],
        ],
        'три' => [
            self::IMENIT => 'три',
            self::RODIT => 'трех',
            self::DAT => 'трем',
            self::VINIT => 'три',
            self::TVORIT => 'тремя',
            self::PREDLOJ => 'трех',
        ],
        'четыре' => [
            self::IMENIT => 'четыре',
            self::RODIT => 'четырех',
            self::DAT => 'четырем',
            self::VINIT => 'четыре',
            self::TVORIT => 'четырьмя',
            self::PREDLOJ => 'четырех',
        ],
        'двести' => [
            self::IMENIT => 'двести',
            self::RODIT => 'двухсот',
            self::DAT => 'двумстам',
            self::VINIT => 'двести',
            self::TVORIT => 'двумястами',
            self::PREDLOJ => 'двухстах',
        ],
        'восемьсот' => [
            self::IMENIT => 'восемьсот',
            self::RODIT => 'восьмисот',
            self::DAT => 'восьмистам',
            self::VINIT => 'восемьсот',
            self::TVORIT => 'восьмистами',
            self::PREDLOJ => 'восьмистах',
        ],
        'тысяча' => [
            self::IMENIT => 'тысяча',
            self::RODIT => 'тысяч',
            self::DAT => 'тысячам',
            self::VINIT => 'тысяч',
            self::TVORIT => 'тысячей',
            self::PREDLOJ => 'тысячах',
        ],
    ];

    /**
     * @param $number
     * @param string $gender
     * @return array
     * @throws \Exception
     */
    public static function getCases($number, $gender = self::MALE)
    {
        // simple numeral
        if (isset(self::$words[$number]) || isset(self::$exponents[$number])) {
            $word = isset(self::$words[$number]) ? self::$words[$number] : self::$exponents[$number];
            if (isset(self::$precalculated[$word])) {
                if (isset(self::$precalculated[$word][self::MALE])) {
                    return self::$precalculated[$word][$gender];
                } else {
                    return self::$precalculated[$word];
                }
            } elseif (($number >= 5 && $number <= 20) || $number == 30) {
                $prefix = S::slice($word, 0, -1);
                return [
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'и',
                    self::DAT => $prefix.'и',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.'ью',
                    self::PREDLOJ => $prefix.'и',
                ];
            } elseif (in_array($number, [40, 90, 100])) {
                $prefix = $number == 40 ? $word : S::slice($word, 0, -1);
                return [
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'а',
                    self::DAT => $prefix.'а',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.'а',
                    self::PREDLOJ => $prefix.'а',
                ];
            } elseif (($number >= 50 && $number <= 80)) {
                $prefix = S::slice($word, 0, -6);
                return [
                    self::IMENIT => $prefix.'ьдесят',
                    self::RODIT => $prefix.'идесяти',
                    self::DAT => $prefix.'идесяти',
                    self::VINIT => $prefix.'ьдесят',
                    self::TVORIT => $prefix.'ьюдесятью',
                    self::PREDLOJ => $prefix.'идесяти',
                ];
            } elseif (in_array($number, [300, 400])) {
                $prefix = S::slice($word, 0, -4);
                return [
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'ехсот',
                    self::DAT => $prefix.'емстам',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.($number == 300 ? 'е' : 'ь').'мястами',
                    self::PREDLOJ => $prefix.'ехстах',
                ];
            } elseif ($number >= 500 && $number <= 900) {
                $prefix = S::slice($word, 0, -4);
                return [
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'исот',
                    self::DAT => $prefix.'истам',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.'ьюстами',
                    self::PREDLOJ => $prefix.'истах',
                ];
            } elseif (isset(self::$exponents[$number])) {
                return NounDeclension::getCases($word, false);
            }
        } elseif ($number == 0) {
            return [
                self::IMENIT => 'ноль',
                self::RODIT => 'ноля',
                self::DAT => 'нолю',
                self::VINIT => 'ноль',
                self::TVORIT => 'нолём',
                self::PREDLOJ => 'ноле',
            ];
        }
        // compound numeral
        else {
            $parts = [];
            $result = [];

            foreach (array_reverse(self::$exponents, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $count = floor($number / $word_number);
                    $parts[] = self::getCases($count, ($word_number == 1000 ? self::FEMALE : self::MALE));

                    switch (NounPluralization::getNumeralForm($count)) {
                        case NounPluralization::ONE:
                            $parts[] = NounDeclension::getCases($word, false);
                            break;

                        case NounPluralization::TWO_FOUR:
                            $part = NounPluralization::getCases($word);
                            if ($word_number != 1000) { // get dative case of word for 1000000, 1000000000 and 1000000000000
                                $part[Cases::IMENIT] = $part[Cases::VINIT] = NounDeclension::getCase($word, Cases::RODIT);
                            }
                            $parts[] = $part;
                            break;

                        case NounPluralization::FIVE_OTHER:
                            $part = NounPluralization::getCases($word);
                            $part[Cases::IMENIT] = $part[Cases::VINIT] = $part[Cases::RODIT];
                            $parts[] = $part;
                            break;
                    }

                    $number = $number % ($count * $word_number);
                }
            }

            foreach (array_reverse(self::$words, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $parts[] = self::getCases($word_number, $gender);
                    $number %= $word_number;
                }
            }

            // make one array with cases and delete 'o/об' prepositional from all parts except the last one
            foreach (array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ) as $case) {
                $result[$case] = [];
                foreach ($parts as $partN => $part) {
                    $result[$case][] = $part[$case];
                }
                $result[$case] = implode(' ', $result[$case]);
            }

            return $result;
        }
    }

    /**
     * @param $number
     * @param $case
     * @param string $gender
     * @return mixed|void
     */
    public static function getCase($number, $case, $gender = self::MALE)
    {
        $case = self::canonizeCase($case);
        $forms = self::getCases($number, $gender);
        return $forms[$case];
    }
}
