<?php
namespace morphos\English;

use morphos\NumeralCreation;

class CardinalNumeral extends NumeralCreation {

    static protected $words = array(
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
    );

    static protected $exponents = array(
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
    );

    static public function getCases($number) {}
    static public function getCase($number, $case) {}

    static public function generate($number) {
        // simple numeral
        if (isset(self::$words[$number]) || isset(self::$exponents[$number])) {
            return isset(self::$words[$number]) ? self::$words[$number] : self::$exponents[$number];
        }
        // compound numeral
        else {
            $parts = array();
            $words = array();

            foreach (array_reverse(self::$exponents, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $count = floor($number / $word_number);
                    $number = $number % ($count * $word_number);
                    $parts[] = self::generate($count).' '.self::generate($word_number).($word_number != 100 && $number > 0 ? ',' : null);
                }
            }

            foreach (array_reverse(self::$words, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $words[] = self::generate($word_number);
                    $number %= $word_number;
                }
            }
            $parts[] = implode('-', $words);

            return implode(' ', $parts);
        }
    }
}
