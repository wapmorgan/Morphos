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

            case Currency::FRANC:
            case 'Fr':
                return Currency::FRANC;

            case Currency::YUAN:
            case '元':
                return Currency::YUAN;

            case Currency::KRONA:
            case 'Kr':
                return Currency::KRONA;

            case Currency::PESO:
                return Currency::PESO;

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

            case Currency::HRYVNIA:
            case '₴':
                return Currency::HRYVNIA;

            default:
                throw new Exception('Invalid currency: '.$currency);
        }
    }
}
