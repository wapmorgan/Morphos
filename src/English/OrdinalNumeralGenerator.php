<?php

namespace morphos\English;

use morphos\NumeralGenerator;
use RuntimeException;

class OrdinalNumeralGenerator extends NumeralGenerator
{
    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    protected static $words = [
        1  => 'first',
        2  => 'second',
        3  => 'third',
        5  => 'fifth',
        8  => 'eighth',
        9  => 'ninth',
        12 => 'twelfth',
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
     * @param bool $short
     * @return string
     */
    public static function generate($number, $short = false)
    {
        // simple numeral
        if (isset(static::$words[$number])) {
            return !$short ? static::$words[$number] : $number . substr(static::$words[$number], -2);
        } elseif (isset(CardinalNumeralGenerator::$words[$number]) || isset(CardinalNumeralGenerator::$exponents[$number])) {
            if ($short) {
                return $number . 'th';
            }
            $word = isset(CardinalNumeralGenerator::$words[$number]) ? CardinalNumeralGenerator::$words[$number] : CardinalNumeralGenerator::$exponents[$number];
            if (substr($word, -1) == 'y') {
                $word = substr($word, 0, -1) . 'ie';
            }
            $word .= 'th';
            return $word;
        } // compound numeral
        else {
            $parts = [];
            $words = [];

            $original_number = $number;

            foreach (array_reverse(CardinalNumeralGenerator::$exponents, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    $count   = (int)floor($number / $word_number);
                    $number  = $number % ($count * $word_number);
                    $parts[] = CardinalNumeralGenerator::generate($count) . ' ' . CardinalNumeralGenerator::generate($word_number) . ($word_number != 100 && $number > 0 ? ',' : null);
                }
            }

            foreach (array_reverse(CardinalNumeralGenerator::$words, true) as $word_number => $word) {
                if ($number >= $word_number) {
                    // if last part
                    if ($number % $word_number === 0) {
                        $words[] = static::generate($word_number);
                    } else {
                        $words[] = CardinalNumeralGenerator::generate($word_number);
                    }
                    $number %= $word_number;
                }
            }
            $parts[] = implode('-', $words);

            if ($short) {
                return $original_number . substr(array_pop($words), -2);
            }

            return implode(' ', $parts);
        }
    }
}
