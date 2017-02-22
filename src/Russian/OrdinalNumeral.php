<?php
namespace morphos\Russian;

use morphos\NumeralCreation;

/**
 * Rules are from http://www.fio.ru/pravila/grammatika/sklonenie-imen-chislitelnykh/
 *            and http://school-collection.edu.ru/dlrstore-wrapper/ebbc76cf-46b6-4d51-ad92-d9a84db35cfa/[I-RUS_06-05]_[TE_16-SU]/[I-RUS_06-05]_[TE_16-SU].html
 */
class OrdinalNumeral extends NumeralCreation implements Cases {
    use RussianLanguage, CasesHelper;

    protected $words = array(
        1 => 'первый',
        2 => 'второй',
        3 => 'третий',
        4 => 'четвертый',
        5 => 'пятый',
        6 => 'шестой',
        7 => 'седьмой',
        8 => 'восьмой',
        9 => 'девятый',
        10 => 'десятый',
        11 => 'одиннадцатый',
        12 => 'двенадцатый',
        13 => 'тринадцатый',
        14 => 'четырнадцатый',
        15 => 'пятнадцатый',
        16 => 'шестнадцатый',
        17 => 'семнадцатый',
        18 => 'восемнадцатый',
        19 => 'девятнадцатый',
        20 => 'двадцатый',
        30 => 'тридцатый',
        40 => 'сороковой',
        50 => 'пятьдесятый',
        60 => 'шестьдесятый',
        70 => 'семьдесятый',
        80 => 'восемьдесятый',
        90 => 'девяностый',
        100 => 'сотый',
        200 => 'двухсотый',
        300 => 'трехсотый',
        400 => 'четырехсотый',
        500 => 'пятисотый',
        600 => 'шестисотый',
        700 => 'семисотый',
        800 => 'восемисотый',
        900 => 'девятисотый',
    );

    protected $exponents = array(
        1000 => 'тысячный',
        1000000 => 'миллионный',
        1000000000 => 'миллиардный',
        1000000000000 => 'триллионный',
    );

    protected $multipliers = array(
        2 => 'двух',
        3 => 'трех',
        4 => 'четырех',
        5 => 'пяти',
        6 => 'шести',
        7 => 'седьми',
        8 => 'восьми',
        9 => 'девяти',
        10 => 'десяти',
        11 => 'одиннадцати',
        12 => 'двенадцати',
        13 => 'тринадцати',
        14 => 'четырнадцати',
        15 => 'пятнадцати',
        16 => 'шестнадцати',
        17 => 'семнадцати',
        18 => 'восемнадцати',
        19 => 'девятнадцати',
        20 => 'двадцати',
        30 => 'тридцати',
        40 => 'сорока',
        50 => 'пятьдесяти',
        60 => 'шестьдесяти',
        70 => 'семьдесяти',
        80 => 'восемьдесяти',
        90 => 'девяности',
        100 => 'сто',
        200 => 'двухста',
        300 => 'трехста',
        400 => 'четырехста',
        500 => 'пятиста',
        600 => 'шестиста',
        700 => 'семиста',
        800 => 'восемиста',
        900 => 'девятиста',
    );

    protected $cardinal;

    public function getCases($number, $gender = self::MALE) {
        // simple numeral
        if (isset($this->words[$number]) || isset($this->exponents[$number])) {
            $word = isset($this->words[$number]) ? $this->words[$number] : $this->exponents[$number];
            // special rules for 3
            if ($number == 3) {
                $prefix = slice($word, 0, -2);
                return array(
                    self::IMENIT => $prefix.($gender == self::MALE ? 'ий' : ($gender == self::FEMALE ? 'ья' : 'ье')),
                    self::RODIT => $prefix.($gender == self::FEMALE ? 'ьей' : 'ьего'),
                    self::DAT => $prefix.($gender == self::FEMALE ? 'ьей' : 'ьему'),
                    self::VINIT => $prefix.($gender == self::FEMALE ? 'ью' : 'ьего'),
                    self::TVORIT => $prefix.($gender == self::FEMALE ? 'ьей' : 'ьим'),
                    self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.($gender == self::FEMALE ? 'ьей' : 'ьем'),
                );
            } else {
                switch ($gender) {
                    case self::MALE:
                        $prefix = slice($word, 0, $number == 40 ? -1 : -2);
                        return array(
                            self::IMENIT => $word,
                            self::RODIT => $prefix.'ого',
                            self::DAT => $prefix.'ому',
                            self::VINIT => $word,
                            self::TVORIT => $prefix.'ым',
                            self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ом',
                        );

                    case self::FEMALE:
                        $prefix = slice($word, 0, $number == 40 ? -1 : -2);
                        return array(
                            self::IMENIT => $prefix.'ая',
                            self::RODIT => $prefix.'ой',
                            self::DAT => $prefix.'ой',
                            self::VINIT => $prefix.'ую',
                            self::TVORIT => $prefix.'ой',
                            self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ой',
                        );

                    case self::NEUTER:
                        $prefix = slice($word, 0, $number == 40 ? -1 : -2);
                        return array(
                            self::IMENIT => $prefix.'ое',
                            self::RODIT => $prefix.'го',
                            self::DAT => $prefix.'ому',
                            self::VINIT => $word,
                            self::TVORIT => $prefix.'ым',
                            self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'ом',
                        );
                }
            }
        }
        // compound numeral
        else {
            $ordinal_part = null;
            $ordinal_prefix = null;
            $cardinal_part = array();
            $result = array();

            // test for exponents. If smaller summand of number is an exponent, declinate it
            foreach (array_reverse($this->exponents, true) as $word_number => $word) {
                if ($number >= $word_number && ($number % $word_number) == 0) {
                    $count = floor($number / $word_number) % 1000;
                    $number -= ($count * $word_number);
                    foreach (array_reverse($this->multipliers, true) as $multiplier => $multipliers_word) {
                        if ($count >= $multiplier) {
                            $ordinal_prefix .= $multipliers_word;
                            $count -= $multiplier;
                        }
                    }
                    $ordinal_part = $this->getCases($word_number, $gender);
                    foreach ($ordinal_part as $case => $ordinal_word) {
                        if ($case == self::PREDLOJ) {
                            list(, $ordinal_part[$case]) = explode(' ', $ordinal_part[$case]);
                            $ordinal_part[$case] = $this->choosePrepositionByFirstLetter($ordinal_prefix, 'об', 'о').' '.$ordinal_prefix.$ordinal_part[$case];
                        } else
                            $ordinal_part[$case] = $ordinal_prefix.$ordinal_part[$case];
                    }

                    break;
                }
            }

            // otherwise, test if smaller summand is just a number with it's own name
            if (empty($ordinal_part)) {
                // get the smallest number with it's own name
                foreach ($this->words as $word_number => $word) {
                    if ($number >= $word_number) {
                        if ($word_number <= 9) {
                            if ($number % 10 == 0) continue;
                            // check for case when word_number smaller than should be used (e.g. 1,2,3 when it can be 4 (number: 344))
                            if (($number % 10) > $word_number) {
                                continue;
                            }
                        } else if ($word_number <= 90) {
                            // check for case when word_number smaller than should be used (e.g. 10, 11, 12 when it can be 13)
                            if (($number % 100) > $word_number) {
                                continue;
                            }
                        }
                        $ordinal_part = $this->getCases($word_number, $gender);
                        $number -= $word_number;
                        break;
                    }
                }
            }

            // if number has second summand, get cardinal form of it
            if ($number > 0) {
                if (empty($this->cardinal)) $this->cardinal = new CardinalNumeral();
                $cardinal_part = $this->cardinal->getCase($number, self::IMENIT, $gender);

                // make one array with cases and delete 'o/об' prepositional from all parts except the last one
                foreach (array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ) as $case) {
                    if ($case == self::PREDLOJ) {
                        list(, $ordinal_part[$case]) = explode(' ', $ordinal_part[$case]);
                        $result[$case] = $this->choosePrepositionByFirstLetter($cardinal_part, 'об', 'о').' '.$cardinal_part.' '.$ordinal_part[$case];
                    } else
                        $result[$case] = $cardinal_part.' '.$ordinal_part[$case];
                }
            } else {
                $result = $ordinal_part;
            }

            return $result;
        }
    }

    public function getCase($number, $case, $gender = self::MALE) {
        $case = self::canonizeCase($case);
        $forms = $this->getCases($number, $gender);
        return $forms[$case];
    }

    static public function generate($number, $gender = self::MALE) {
        static $card;
        if ($card === null) $card = new self();

        return $card->getCase($number, self::IMENIT, $gender);
    }
}
