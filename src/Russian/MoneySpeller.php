<?php
namespace morphos\Russian;

use morphos\Gender;
use morphos\CurrenciesHelper;

class MoneySpeller extends \morphos\MoneySpeller
{
    use CurrenciesHelper;

    protected static $labels = [
        self::DOLLAR => ['доллар', Gender::MALE, 'цент', Gender::MALE],
        self::EURO => ['евро', Gender::NEUTER, 'цент', Gender::MALE],
        self::YEN => ['иена', Gender::FEMALE, 'сен', Gender::MALE],
        self::POUND => ['фунт', Gender::MALE, 'пенни', Gender::NEUTER],
        self::FRANC => ['франк', Gender::MALE, 'сантим', Gender::MALE],
        self::YUAN => ['юань', Gender::MALE, 'цзяо', Gender::NEUTER],
        self::KRONA => ['крона', Gender::FEMALE, 'эре', Gender::NEUTER],
        self::PESO => ['песо', Gender::NEUTER, 'сентаво', Gender::NEUTER],
        self::WON => ['вон', Gender::MALE, 'чон', Gender::MALE],
        self::LIRA => ['лира', Gender::FEMALE, 'куруш', Gender::MALE],
        self::RUBLE => ['рубль', Gender::MALE, 'копейка', Gender::FEMALE],
        self::RUPEE => ['рупия', Gender::FEMALE, 'пайка', Gender::FEMALE],
        self::REAL => ['реал', Gender::MALE, 'сентаво', Gender::NEUTER],
        self::RAND => ['рэнд', Gender::MALE, 'цент', Gender::MALE],
        self::HRYVNIA => ['гривна', Gender::FEMALE, 'копейка', Gender::FEMALE],
    ];

    /**
     * @param float|integer $value
     * @param string $currency
     * @param string $format
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function spell($value, $currency, $format = self::NORMAL_FORMAT)
    {
        $currency = static::canonizeCurrency($currency);

        $integer = floor($value);
        $fractional = floor(($value * 100) % 100);

        switch ($format) {
            case static::SHORT_FORMAT:
                return $integer.' '.NounPluralization::pluralize(static::$labels[$currency][0], $integer)
                    .($fractional > 0
                        ? ' '.$fractional.' '.NounPluralization::pluralize(static::$labels[$currency][2], $fractional)
                        : null);

            case static::NORMAL_FORMAT:
            case static::CLARIFICATION_FORMAT:
            case static::DUPLICATION_FORMAT:

                $integer_speelled = CardinalNumeralGenerator::getCase($integer, Cases::IMENIT, static::$labels[$currency][1]);
                $fractional_speelled = CardinalNumeralGenerator::getCase($fractional, Cases::IMENIT, static::$labels[$currency][3]);

                if ($format == static::CLARIFICATION_FORMAT) {
                    return $integer.' ('.$integer_speelled.') '.NounPluralization::pluralize(static::$labels[$currency][0], $integer).' '.$fractional.' ('.$fractional_speelled.') '.NounPluralization::pluralize(static::$labels[$currency][2], $fractional);
                } else {
                    return $integer_speelled.($format == static::DUPLICATION_FORMAT ? ' ('.$integer.')' : null).' '.NounPluralization::pluralize(static::$labels[$currency][0], $integer).' '.$fractional_speelled.($format == static::DUPLICATION_FORMAT ? ' ('.$fractional.')' : null).' '.NounPluralization::pluralize(static::$labels[$currency][2], $fractional);
                }
        }
    }
}
