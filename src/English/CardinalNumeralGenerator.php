<?php

namespace morphos\English;

use morphos\NumeralGenerator;
use RuntimeException;

class CardinalNumeralGenerator extends NumeralGenerator
{
    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    public static $words = [
        1  => 'one',
        2  => 'two',
        3  => 'three',
        4  => 'four',
        5  => 'five',
        6  => 'six',
        7  => 'seven',
        8  => 'eight',
        9  => 'nine',
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
    ];

    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    public static $exponents = [
        100           => 'hundred',
        1000          => 'thousand',
        1000000       => 'million',
        1000000000    => 'billion',
        1000000000000 => 'trillion',
    ];

    public static function getCases($number)
    {
        throw new RuntimeException('Not implemented');
    }

    public static function getCase($number, $case)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @param int $number
     * @return mixed|string
     */
    public static function generate($number)
    {
        // simple numeral
        if (isset(static::$words[$number]) || isset(static::$exponents[$number])) {
            return isset(static::$words[$number]) ? static::$words[$number] : static::$exponents[$number];
        } // compound numeral
        else {
            $parts = [];
            $words = [];

            foreach (array_reverse(static::$exponents, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $count   = (int)floor($number / $word_number);
                    $number  = $number % ($count * $word_number);
                    $parts[] = static::generate($count) . ' ' . static::generate($word_number) . ($word_number != 100 && $number > 0 ? ',' : null);
                }
            }

            foreach (array_reverse(static::$words, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $words[] = static::generate($word_number);
                    $number  %= $word_number;
                }
            }
            $parts[] = implode('-', $words);

            return implode(' ', $parts);
        }
    }
}
