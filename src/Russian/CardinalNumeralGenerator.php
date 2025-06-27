<?php

namespace morphos\Russian;

use morphos\CasesHelper;
use morphos\NumeralGenerator;
use morphos\S;
use RuntimeException;

/**
 * Rules are from http://www.fio.ru/pravila/grammatika/sklonenie-imen-chislitelnykh/
 */
class CardinalNumeralGenerator extends NumeralGenerator implements Cases
{
    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    protected static $words = [
        1   => 'один',
        2   => 'два',
        3   => 'три',
        4   => 'четыре',
        5   => 'пять',
        6   => 'шесть',
        7   => 'семь',
        8   => 'восемь',
        9   => 'девять',
        10  => 'десять',
        11  => 'одиннадцать',
        12  => 'двенадцать',
        13  => 'тринадцать',
        14  => 'четырнадцать',
        15  => 'пятнадцать',
        16  => 'шестнадцать',
        17  => 'семнадцать',
        18  => 'восемнадцать',
        19  => 'девятнадцать',
        20  => 'двадцать',
        30  => 'тридцать',
        40  => 'сорок',
        50  => 'пятьдесят',
        60  => 'шестьдесят',
        70  => 'семьдесят',
        80  => 'восемьдесят',
        90  => 'девяносто',
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

    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    protected static $exponents = [
        1000             => 'тысяча',
        1000000          => 'миллион',
        1000000000       => 'миллиард',
        1000000000000    => 'триллион',
        1000000000000000 => 'квадриллион',
    ];

    /**
     * @var array
     * @phpstan-var array<string, array<string, array<string, string>|string>>
     */
    protected static $precalculated = [
        'один'        => [
            self::MALE   => [
                self::IMENIT  => 'один',
                self::RODIT   => 'одного',
                self::DAT     => 'одному',
                self::VINIT   => 'один',
                self::TVORIT  => 'одним',
                self::PREDLOJ => 'одном',
            ],
            self::FEMALE => [
                self::IMENIT  => 'одна',
                self::RODIT   => 'одной',
                self::DAT     => 'одной',
                self::VINIT   => 'одну',
                self::TVORIT  => 'одной',
                self::PREDLOJ => 'одной',
            ],
            self::NEUTER => [
                self::IMENIT  => 'одно',
                self::RODIT   => 'одного',
                self::DAT     => 'одному',
                self::VINIT   => 'одно',
                self::TVORIT  => 'одним',
                self::PREDLOJ => 'одном',
            ],
        ],
        'два'         => [
            self::MALE   => [
                self::IMENIT  => 'два',
                self::RODIT   => 'двух',
                self::DAT     => 'двум',
                self::VINIT   => 'два',
                self::TVORIT  => 'двумя',
                self::PREDLOJ => 'двух',
            ],
            self::FEMALE => [
                self::IMENIT  => 'две',
                self::RODIT   => 'двух',
                self::DAT     => 'двум',
                self::VINIT   => 'две',
                self::TVORIT  => 'двумя',
                self::PREDLOJ => 'двух',
            ],
            self::NEUTER => [
                self::IMENIT  => 'два',
                self::RODIT   => 'двух',
                self::DAT     => 'двум',
                self::VINIT   => 'два',
                self::TVORIT  => 'двумя',
                self::PREDLOJ => 'двух',
            ],
        ],
        'три'         => [
            self::IMENIT  => 'три',
            self::RODIT   => 'трех',
            self::DAT     => 'трем',
            self::VINIT   => 'три',
            self::TVORIT  => 'тремя',
            self::PREDLOJ => 'трех',
        ],
        'четыре'      => [
            self::IMENIT  => 'четыре',
            self::RODIT   => 'четырех',
            self::DAT     => 'четырем',
            self::VINIT   => 'четыре',
            self::TVORIT  => 'четырьмя',
            self::PREDLOJ => 'четырех',
        ],
        'восемь'      => [
            self::IMENIT  => 'восемь',
            self::RODIT   => 'восьми',
            self::DAT     => 'восьми',
            self::VINIT   => 'восемь',
            self::TVORIT  => 'восемью',
            self::PREDLOJ => 'восьми',
        ],
        'восемьдесят' => [
            self::IMENIT  => 'восемьдесят',
            self::RODIT   => 'восьмидесяти',
            self::DAT     => 'восьмидесяти',
            self::VINIT   => 'восемьдесят',
            self::TVORIT  => 'восемьюдесятью',
            self::PREDLOJ => 'восьмидесяти',
        ],
        'двести'      => [
            self::IMENIT  => 'двести',
            self::RODIT   => 'двухсот',
            self::DAT     => 'двумстам',
            self::VINIT   => 'двести',
            self::TVORIT  => 'двумястами',
            self::PREDLOJ => 'двухстах',
        ],
        'восемьсот'   => [
            self::IMENIT  => 'восемьсот',
            self::RODIT   => 'восьмисот',
            self::DAT     => 'восьмистам',
            self::VINIT   => 'восемьсот',
            self::TVORIT  => 'восьмистами',
            self::PREDLOJ => 'восьмистах',
        ],
    ];

    /**
     * @param int $number
     * @param string $gender
     * @param bool $forAccounting
     * @return string[]
     * @phpstan-return array<string, string>
     * @throws \Exception
     */
    public static function getCases($number, $gender = self::MALE, $forAccounting = false)
    {
        // simple numeral
        if (isset(static::$words[$number]) || isset(static::$exponents[$number])) {
            $word = isset(static::$words[$number]) ? static::$words[$number] : static::$exponents[$number];
            if (isset(static::$precalculated[$word])) {
                if (isset(static::$precalculated[$word][static::MALE])) {
                    return static::$precalculated[$word][$gender];
                } else {
                    return static::$precalculated[$word];
                }
            } elseif (($number >= 5 && $number <= 20) || $number == 30) {
                $prefix = S::slice($word, 0, -1);
                return [
                    static::IMENIT  => $word,
                    static::RODIT   => $prefix . 'и',
                    static::DAT     => $prefix . 'и',
                    static::VINIT   => $word,
                    static::TVORIT  => $prefix . 'ью',
                    static::PREDLOJ => $prefix . 'и',
                ];
            } elseif (in_array($number, [40, 90, 100])) {
                $prefix = $number == 40 ? $word : S::slice($word, 0, -1);
                return [
                    static::IMENIT  => $word,
                    static::RODIT   => $prefix . 'а',
                    static::DAT     => $prefix . 'а',
                    static::VINIT   => $word,
                    static::TVORIT  => $prefix . 'а',
                    static::PREDLOJ => $prefix . 'а',
                ];
            } elseif (($number >= 50 && $number <= 80)) {
                $prefix = S::slice($word, 0, -6);
                return [
                    static::IMENIT  => $prefix . 'ьдесят',
                    static::RODIT   => $prefix . 'идесяти',
                    static::DAT     => $prefix . 'идесяти',
                    static::VINIT   => $prefix . 'ьдесят',
                    static::TVORIT  => $prefix . 'ьюдесятью',
                    static::PREDLOJ => $prefix . 'идесяти',
                ];
            } elseif (in_array($number, [300, 400])) {
                $prefix = S::slice($word, 0, -4);
                return [
                    static::IMENIT  => $word,
                    static::RODIT   => $prefix . 'ехсот',
                    static::DAT     => $prefix . 'емстам',
                    static::VINIT   => $word,
                    static::TVORIT  => $prefix . ($number == 300 ? 'е' : 'ь') . 'мястами',
                    static::PREDLOJ => $prefix . 'ехстах',
                ];
            } elseif ($number >= 500 && $number <= 900) {
                $prefix = S::slice($word, 0, -4);
                return [
                    static::IMENIT  => $word,
                    static::RODIT   => $prefix . 'исот',
                    static::DAT     => $prefix . 'истам',
                    static::VINIT   => $word,
                    static::TVORIT  => $prefix . 'ьюстами',
                    static::PREDLOJ => $prefix . 'истах',
                ];
            } elseif (isset(static::$exponents[$number])) {
                if ($forAccounting) {
                    return array_combine(
                        CasesHelper::getAllCases(),
                        array_map(
                            [__CLASS__, 'joinTwoStringsWithSpace'],
                            static::getCases(1, $gender),
                            NounDeclension::getCases($word, false)
                        )
                    );
                }
                return NounDeclension::getCases($word, false);
            }

            throw new RuntimeException('Unreachable');
        }

        if ($number == 0) {
            return [
                static::IMENIT  => 'ноль',
                static::RODIT   => 'ноля',
                static::DAT     => 'нолю',
                static::VINIT   => 'ноль',
                static::TVORIT  => 'нолём',
                static::PREDLOJ => 'ноле',
            ];
        } // compound numeral

        $parts  = [];
        $result = [];

        foreach (array_reverse(static::$exponents, true) as $word_number => $word) {
            if ($number >= $word_number) {
                $count   = (int)floor($number / $word_number);
                $parts[] = static::getCases($count, ($word_number == 1000 ? static::FEMALE : static::MALE));

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
                        $part                = NounPluralization::getCases($word);
                        $part[Cases::IMENIT] = $part[Cases::VINIT] = $part[Cases::RODIT];
                        $parts[]             = $part;
                        break;
                }

                $number = $number % ($count * $word_number);
            }
        }

        foreach (array_reverse(static::$words, true) as $word_number => $word) {
            if ($number >= $word_number) {
                $parts[] = static::getCases($word_number, $gender);
                $number  %= $word_number;
            }
        }

        // make one array with cases and delete 'o/об' prepositional from all parts except the last one
        foreach ([
                     static::IMENIT,
                     static::RODIT,
                     static::DAT,
                     static::VINIT,
                     static::TVORIT,
                     static::PREDLOJ,
                 ] as $case) {
            $result[$case] = [];
            foreach ($parts as $partN => $part) {
                $result[$case][] = $part[$case];
            }
            $result[$case] = implode(' ', $result[$case]);
        }

        return $result;
    }

    /**
     * @param int $number
     * @param string $case
     * @param string $gender
     * @param bool $forAccounting
     *
     * @return string
     * @throws \Exception
     */
    public static function getCase($number, $case, $gender = self::MALE, $forAccounting = false)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($number, $gender, $forAccounting);
        return $forms[$case];
    }

    public static function joinTwoStringsWithSpace($a, $b)
    {
        return $a . ' ' . $b;
    }
}
