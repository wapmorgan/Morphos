<?php
namespace morphos\Russian;

use morphos\NumeralCreation;
use morphos\S;

/**
 * Rules are from http://www.fio.ru/pravila/grammatika/sklonenie-imen-chislitelnykh/
 */
class CardinalNumeral extends NumeralCreation implements Cases {
    use RussianLanguage, CasesHelper;

    static protected $words = array(
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
    );

    static protected $exponents = array(
        1000 => 'тысяча',
        1000000 => 'миллион',
        1000000000 => 'миллиард',
        1000000000000 => 'триллион',
    );

    static protected $precalculated = array(
        'один' => array(
            self::MALE => array(
                self::IMENIT => 'один',
                self::RODIT => 'одного',
                self::DAT => 'одному',
                self::VINIT => 'один',
                self::TVORIT => 'одним',
                self::PREDLOJ => 'об одном',
            ),
            self::FEMALE => array(
                self::IMENIT => 'одна',
                self::RODIT => 'одной',
                self::DAT => 'одной',
                self::VINIT => 'одну',
                self::TVORIT => 'одной',
                self::PREDLOJ => 'об одной',
            ),
            self::NEUTER => array(
                self::IMENIT => 'одно',
                self::RODIT => 'одного',
                self::DAT => 'одному',
                self::VINIT => 'одно',
                self::TVORIT => 'одним',
                self::PREDLOJ => 'об одном',
            ),
        ),
        'два' => array(
            self::MALE => array(
                self::IMENIT => 'два',
                self::RODIT => 'двух',
                self::DAT => 'двум',
                self::VINIT => 'два',
                self::TVORIT => 'двумя',
                self::PREDLOJ => 'о двух',
            ),
            self::FEMALE => array(
                self::IMENIT => 'две',
                self::RODIT => 'двух',
                self::DAT => 'двум',
                self::VINIT => 'два',
                self::TVORIT => 'двумя',
                self::PREDLOJ => 'о двух',
            ),
            self::NEUTER => array(
                self::IMENIT => 'два',
                self::RODIT => 'двух',
                self::DAT => 'двум',
                self::VINIT => 'два',
                self::TVORIT => 'двумя',
                self::PREDLOJ => 'о двух',
            ),
        ),
        'три' => array(
            self::IMENIT => 'три',
            self::RODIT => 'трех',
            self::DAT => 'трем',
            self::VINIT => 'три',
            self::TVORIT => 'тремя',
            self::PREDLOJ => 'о трех',
        ),
        'четыре' => array(
            self::IMENIT => 'четыре',
            self::RODIT => 'четырех',
            self::DAT => 'четырем',
            self::VINIT => 'четыре',
            self::TVORIT => 'четырьмя',
            self::PREDLOJ => 'о четырех',
        ),
        'двести' => array(
            self::IMENIT => 'двести',
            self::RODIT => 'двухсот',
            self::DAT => 'двумстам',
            self::VINIT => 'двести',
            self::TVORIT => 'двумястами',
            self::PREDLOJ => 'о двухстах',
        ),
        'восемьсот' => array(
            self::IMENIT => 'восемьсот',
            self::RODIT => 'восьмисот',
            self::DAT => 'восьмистам',
            self::VINIT => 'восемьсот',
            self::TVORIT => 'восьмистами',
            self::PREDLOJ => 'о восьмистах',
        ),
        'тысяча' => array(
            self::IMENIT => 'тысяча',
            self::RODIT => 'тысяч',
            self::DAT => 'тысячам',
            self::VINIT => 'тысяч',
            self::TVORIT => 'тысячей',
            self::PREDLOJ => 'о тысячах',
        ),
    );

    static public function getCases($number, $gender = self::MALE) {
        // simple numeral
        if (isset(self::$words[$number]) || isset(self::$exponents[$number])) {
            $word = isset(self::$words[$number]) ? self::$words[$number] : self::$exponents[$number];
            if (isset(self::$precalculated[$word])) {
                if (isset(self::$precalculated[$word][self::MALE])) {
                    return self::$precalculated[$word][$gender];
                } else {
                    return self::$precalculated[$word];
                }
            } else if (($number >= 5 && $number <= 20) || $number == 30) {
                $prefix = S::slice($word, 0, -1);
                return array(
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'и',
                    self::DAT => $prefix.'и',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.'ью',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
                );
            } else if (in_array($number, array(40, 90, 100))) {
                $prefix = $number == 40 ? $word : S::slice($word, 0, -1);
                return array(
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'а',
                    self::DAT => $prefix.'а',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.'а',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'а',
                );
            } else if (($number >= 50 && $number <= 80)) {
                $prefix = S::slice($word, 0, -6);
                return array(
                    self::IMENIT => $prefix.'ьдесят',
                    self::RODIT => $prefix.'идесяти',
                    self::DAT => $prefix.'идесяти',
                    self::VINIT => $prefix.'ьдесят',
                    self::TVORIT => $prefix.'ьюдесятью',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($word, 'об', 'о').' '.$prefix.'идесяти',
                );
            } else if (in_array($number, array(300, 400))) {
                $prefix = S::slice($word, 0, -4);
                return array(
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'ехсот',
                    self::DAT => $prefix.'емстам',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.($number == 300 ? 'е' : 'ь').'мястами',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($word, 'об', 'о').' '.$prefix.'ехстах',
                );
            } else if ($number >= 500 && $number <= 900) {
                $prefix = S::slice($word, 0, -4);
                return array(
                    self::IMENIT => $word,
                    self::RODIT => $prefix.'исот',
                    self::DAT => $prefix.'истам',
                    self::VINIT => $word,
                    self::TVORIT => $prefix.'ьюстами',
                    self::PREDLOJ => self::choosePrepositionByFirstLetter($word, 'об', 'о').' '.$prefix.'истах',
                );
            } else if (isset(self::$exponents[$number])) {
                return GeneralDeclension::getCases($word, false);
            }
        }
        // compound numeral
        else {
            $parts = array();
            $result = array();

            foreach (array_reverse(self::$exponents, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $count = floor($number / $word_number);
                    $parts[] = self::getCases($count, ($word_number == 1000 ? self::FEMALE : self::MALE));

                    switch (Plurality::getNumeralForm($count)) {
                        case Plurality::ONE:
                            $parts[] = GeneralDeclension::getCases($word, false);
                            break;
                        case Plurality::TWO_FOUR:
                            $part = Plurality::getCases($word);
                            if ($word_number != 1000) // get dative case of word for 1000000, 1000000000 and 1000000000000
                                $part[Cases::IMENIT] = $part[Cases::VINIT] = GeneralDeclension::getCase($word, Cases::RODIT);
                            $parts[] = $part;
                            break;
                        case Plurality::FIVE_OTHER:
                            $part = Plurality::getCases($word);
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
                $result[$case] = array();
                foreach ($parts as $partN => $part) {
                    if ($case == self::PREDLOJ && $partN > 0) list(, $part[$case]) = explode(' ', $part[$case], 2);
                    $result[$case][] = $part[$case];
                }
                $result[$case] = implode(' ', $result[$case]);
            }

            return $result;
        }
    }

    static public function getCase($number, $case, $gender = self::MALE) {
        $case = self::canonizeCase($case);
        $forms = self::getCases($number, $gender);
        return $forms[$case];
    }
}
