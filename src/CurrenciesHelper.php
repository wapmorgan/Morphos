<?php
namespace morphos;

use Exception;

trait CurrenciesHelper {
    static public function canonizeCurrency($currency) {
        switch ($currency) {
            case Currency::DOLLAR:
            case '$':
                return Currency::DOLLAR;

            case Currency::EURO:
            case '€':
                return Currency::EURO;

            case Currency::YEN:
            case '¥':
                return Currency::YEN;

            case Currency::POUND:
            case '£':
                return Currency::POUND;

            case Currency::AUSTRALIAN_DOLLAR:
            case 'A$':
                return Currency::AUSTRALIAN_DOLLAR;

            case Currency::CANADIAN_DOLLAR:
            case 'C$':
                return Currency::CANADIAN_DOLLAR;

            case Currency::FRANC:
            case 'Fr':
                return Currency::FRANC;

            case Currency::YUAN:
            case '元':
                return Currency::YUAN;

            case Currency::KRONA:
            case 'Kr':
                return Currency::KRONA;

            case Currency::ZELAND_DOLLAR:
            case 'NZ$':
                return Currency::ZELAND_DOLLAR;

            case Currency::PESO:
                return Currency::PESO;

            case Currency::SINGAPORE_DOLLAR:
            case 'S$':
                return Currency::SINGAPORE_DOLLAR;

            case Currency::HONG_KONG_DOLLAR:
            case 'HK$':
                return Currency::HONG_KONG_DOLLAR;

            case Currency::WON:
            case '₩':
                return Currency::WON;

            case Currency::LIRA:
            case '₺':
                return Currency::LIRA;

            case Currency::RUBLE:
            case '₽':
                return Currency::RUBLE;

            case Currency::RUPEE:
            case '₹':
                return Currency::RUPEE;

            case Currency::REAL:
            case 'R$':
                return Currency::REAL;

            case Currency::RAND:
            case 'R':
                return Currency::RAND;

            default:
                throw new Exception('Invalid currency: '.$currency);
        }
    }
}
