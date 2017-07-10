<?php
namespace morphos\English;

use morphos\NumeralCreation;

class OrdinalNumeral extends NumeralCreation {

    static protected $words = array(
        1 => 'first',
        2 => 'second',
        3 => 'third',
        5 => 'fifth',
        8 => 'eighth',
        9 => 'ninth',
        12 => 'twelfth',
    );

    static public function getCases($number) {}
    static public function getCase($number, $case) {}

    static public function generate($number, $short = false) {
        // simple numeral
        if (isset(self::$words[$number])) {
            return !$short ? self::$words[$number] : $number.substr(self::$words[$number], -2);
        } else if (isset(CardinalNumeral::$words[$number]) || isset(CardinalNumeral::$exponents[$number])) {
            if ($short) return $number.'th';
            $word = isset(CardinalNumeral::$words[$number]) ? CardinalNumeral::$words[$number] : CardinalNumeral::$exponents[$number];
            if (substr($word, -1) == 'y') $word = substr($word, 0, -1).'ie';
            $word .= 'th';
            return $word;
        }
        // compound numeral
        else {
            $parts = array();
            $words = array();

            $original_number = $number;

            foreach (array_reverse(CardinalNumeral::$exponents, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $count = floor($number / $word_number);
                    $number = $number % ($count * $word_number);
                    $parts[] = CardinalNumeral::generate($count).' '.CardinalNumeral::generate($word_number).($word_number != 100 && $number > 0 ? ',' : null);
                }
            }

            foreach (array_reverse(CardinalNumeral::$words, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    // if last part
                    if ($number % $word_number === 0)
                        $words[] = self::generate($word_number);
                    else
                        $words[] = CardinalNumeral::generate($word_number);
                    $number %= $word_number;
                }
            }
            $parts[] = implode('-', $words);

            if ($short) return $original_number.substr(array_pop($words), -2);

            return implode(' ', $parts);
        }
    }
}
