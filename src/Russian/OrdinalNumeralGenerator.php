<?php

namespace morphos\Russian;

use morphos\NumeralGenerator;
use morphos\S;
use RuntimeException;

/**
 * Rules are from http://www.fio.ru/pravila/grammatika/sklonenie-imen-chislitelnykh/
 *            and http://school-collection.edu.ru/dlrstore-wrapper/ebbc76cf-46b6-4d51-ad92-d9a84db35cfa/[I-RUS_06-05]_[TE_16-SU]/[I-RUS_06-05]_[TE_16-SU].html
 */
class OrdinalNumeralGenerator extends NumeralGenerator implements Cases
{
    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    protected static $words = [
        1   => 'первый',
        2   => 'второй',
        3   => 'третий',
        4   => 'четвертый',
        5   => 'пятый',
        6   => 'шестой',
        7   => 'седьмой',
        8   => 'восьмой',
        9   => 'девятый',
        10  => 'десятый',
        11  => 'одиннадцатый',
        12  => 'двенадцатый',
        13  => 'тринадцатый',
        14  => 'четырнадцатый',
        15  => 'пятнадцатый',
        16  => 'шестнадцатый',
        17  => 'семнадцатый',
        18  => 'восемнадцатый',
        19  => 'девятнадцатый',
        20  => 'двадцатый',
        30  => 'тридцатый',
        40  => 'сороковой',
        50  => 'пятидесятый',
        60  => 'шестидесятый',
        70  => 'семидесятый',
        80  => 'восьмидесятый',
        90  => 'девяностый',
        100 => 'сотый',
        200 => 'двухсотый',
        300 => 'трехсотый',
        400 => 'четырехсотый',
        500 => 'пятисотый',
        600 => 'шестисотый',
        700 => 'семисотый',
        800 => 'восьмисотый',
        900 => 'девятисотый',
    ];

    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    protected static $exponents = [
        1000          => 'тысячный',
        1000000       => 'миллионный',
        1000000000    => 'миллиардный',
        1000000000000 => 'триллионный',
    ];

    /**
     * @var string[]
     * @phpstan-var array<int, string>
     */
    protected static $multipliers = [
        2   => 'двух',
        3   => 'трех',
        4   => 'четырех',
        5   => 'пяти',
        6   => 'шести',
        7   => 'седьми',
        8   => 'восьми',
        9   => 'девяти',
        10  => 'десяти',
        11  => 'одиннадцати',
        12  => 'двенадцати',
        13  => 'тринадцати',
        14  => 'четырнадцати',
        15  => 'пятнадцати',
        16  => 'шестнадцати',
        17  => 'семнадцати',
        18  => 'восемнадцати',
        19  => 'девятнадцати',
        20  => 'двадцати',
        30  => 'тридцати',
        40  => 'сорока',
        50  => 'пятьдесяти',
        60  => 'шестьдесяти',
        70  => 'семьдесяти',
        80  => 'восемьдесяти',
        90  => 'девяности',
        100 => 'сто',
        200 => 'двухста',
        300 => 'трехста',
        400 => 'четырехста',
        500 => 'пятиста',
        600 => 'шестиста',
        700 => 'семиста',
        800 => 'восемиста',
        900 => 'девятиста',
    ];

    /**
     * @param int $number
     * @param string $gender
     *
     * @return string[]
     * @phpstan-return array<string, string>
     * @throws \Exception
     */
    public static function getCases($number, $gender = self::MALE)
    {
        // simple numeral
        if (isset(static::$words[$number]) || isset(static::$exponents[$number])) {
            $word = isset(static::$words[$number]) ? static::$words[$number] : static::$exponents[$number];
            // special rules for 3
            if ($number == 3) {
                $prefix = S::slice($word, 0, -2);
                return [
                    static::IMENIT  => $prefix . ($gender == static::MALE ? 'ий' : ($gender == static::FEMALE ? 'ья' : 'ье')),
                    static::RODIT   => $prefix . ($gender == static::FEMALE ? 'ьей' : 'ьего'),
                    static::DAT     => $prefix . ($gender == static::FEMALE ? 'ьей' : 'ьему'),
                    static::VINIT   => $prefix . ($gender == static::FEMALE ? 'ью' : 'ьего'),
                    static::TVORIT  => $prefix . ($gender == static::FEMALE ? 'ьей' : 'ьим'),
                    static::PREDLOJ => $prefix . ($gender == static::FEMALE ? 'ьей' : 'ьем'),
                ];
            }

            switch ($gender) {
                case static::MALE:
                    $prefix = S::slice($word, 0, -2);
                    return [
                        static::IMENIT  => $word,
                        static::RODIT   => $prefix . 'ого',
                        static::DAT     => $prefix . 'ому',
                        static::VINIT   => $word,
                        static::TVORIT  => $prefix . 'ым',
                        static::PREDLOJ => $prefix . 'ом',
                    ];

                case static::FEMALE:
                    $prefix = S::slice($word, 0, -2);
                    return [
                        static::IMENIT  => $prefix . 'ая',
                        static::RODIT   => $prefix . 'ой',
                        static::DAT     => $prefix . 'ой',
                        static::VINIT   => $prefix . 'ую',
                        static::TVORIT  => $prefix . 'ой',
                        static::PREDLOJ => $prefix . 'ой',
                    ];

                case static::NEUTER:
                    $prefix = S::slice($word, 0, -2);
                    return [
                        static::IMENIT  => $prefix . 'ое',
                        static::RODIT   => $prefix . 'ого',
                        static::DAT     => $prefix . 'ому',
                        static::VINIT   => $prefix . 'ое',
                        static::TVORIT  => $prefix . 'ым',
                        static::PREDLOJ => $prefix . 'ом',
                    ];

                default:
                    throw new RuntimeException('Unreacheable');
            }
        }

        // compound numeral
        $ordinal_part   = null;
        $ordinal_prefix = null;
        $result         = [];

        // test for exponents. If smaller summand of number is an exponent, declinate it
        foreach (array_reverse(static::$exponents, true) as $word_number => $word) {
            if ($number >= $word_number && ($number % $word_number) == 0) {
                $count  = floor($number / $word_number) % 1000;
                $number -= ($count * $word_number);
                foreach (array_reverse(static::$multipliers, true) as $multiplier => $multipliers_word) {
                    if ($count >= $multiplier) {
                        $ordinal_prefix .= $multipliers_word;
                        $count          -= $multiplier;
                    }
                }
                $ordinal_part = static::getCases($word_number, $gender);
                foreach ($ordinal_part as $case => $ordinal_word) {
                    $ordinal_part[$case] = $ordinal_prefix . $ordinal_part[$case];
                }

                break;
            }
        }

        // otherwise, test if smaller summand is just a number with it's own name
        if (empty($ordinal_part)) {
            // get the smallest number with it's own name
            foreach (static::$words as $word_number => $word) {
                if ($number >= $word_number) {
                    if ($word_number <= 9) {
                        if ($number % 10 == 0) {
                            continue;
                        }
                        // check for case when word_number smaller than should be used (e.g. 1,2,3 when it can be 4 (number: 344))
                        if (($number % 10) > $word_number) {
                            continue;
                        }
                        // check that there is no two-digits number with it's own name (e.g. 13 for 113)
                        if (isset(static::$words[$number % 100]) && $number % 100 > $word_number) {
                            continue;
                        }
                    } elseif ($word_number <= 90) {
                        // check for case when word_number smaller than should be used (e.g. 10, 11, 12 when it can be 13)
                        if (($number % 100) > $word_number) {
                            continue;
                        }
                    }
                    $ordinal_part = static::getCases($word_number, $gender);
                    $number       -= $word_number;
                    break;
                }
            }
        }

        // if number has second summand, get cardinal form of it
        if ($number > 0) {
            $cardinal_part = CardinalNumeralGenerator::getCase($number, static::IMENIT, $gender);

            // make one array with cases and delete 'o/об' prepositional from all parts except the last one
            foreach ([
                         static::IMENIT,
                         static::RODIT,
                         static::DAT,
                         static::VINIT,
                         static::TVORIT,
                         static::PREDLOJ,
                     ] as $case) {
                $result[$case] = $cardinal_part . ' ' . $ordinal_part[$case];
            }
        } else {
            $result = $ordinal_part;
        }

        return $result;
    }

    /**
     * @param int $number
     * @param string $case
     * @param string $gender
     * @return mixed
     * @throws \Exception
     */
    public static function getCase($number, $case, $gender = self::MALE)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($number, $gender);
        return $forms[$case];
    }
}
