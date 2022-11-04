<?php

namespace morphos\test\Russian;

use morphos\Currency;
use morphos\Russian\Cases;
use morphos\Russian\MoneySpeller;
use PHPUnit\Framework\TestCase;

class MoneySpellerTest extends TestCase
{

    /**
     * @dataProvider moneyAmountsProvider()
     *
     * @param      $value
     * @param      $currency
     * @param      $format
     * @param      $result
     *
     * @param null $case
     *
     * @throws \Exception
     */
    public function testSpell(
        $value,
        $currency,
        $format,
        $result,
        $case = null
    ) {
        $this->assertEquals($result, MoneySpeller::spell($value, $currency, $format, $case));
    }

    public function moneyAmountsProvider()
    {
        return
            [
                [123.45, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '123 рубля 45 копеек'],
                [
                    321.54,
                    Currency::DOLLAR,
                    MoneySpeller::NORMAL_FORMAT,
                    'триста двадцать один доллар пятьдесят четыре цента',
                ],
                [
                    321.54,
                    Currency::DOLLAR,
                    MoneySpeller::NORMAL_FORMAT,
                    'трехсот двадцати одного доллара пятидесяти четырех центов',
                    Cases::RODIT,
                ],
                [
                    369.12,
                    Currency::EURO,
                    MoneySpeller::DUPLICATION_FORMAT,
                    'триста шестьдесят девять (369) евро двенадцать (12) центов',
                ],
                [
                    246.35,
                    Currency::YEN,
                    MoneySpeller::CLARIFICATION_FORMAT,
                    '246 (двести сорок шесть) иен 35 (тридцать пять) сенов',
                ],
                [123, Currency::POUND, MoneySpeller::SHORT_FORMAT, '123 фунта'],
                [123, Currency::FRANC, MoneySpeller::SHORT_FORMAT, '123 франка'],
                [123, Currency::YUAN, MoneySpeller::SHORT_FORMAT, '123 юаня'],
                [123, Currency::HRYVNIA, MoneySpeller::SHORT_FORMAT, '123 гривны'],
                [123, Currency::KRONA, MoneySpeller::SHORT_FORMAT, '123 кроны'],
                [123, Currency::PESO, MoneySpeller::SHORT_FORMAT, '123 песо'],
                [123, Currency::FRANC, MoneySpeller::SHORT_FORMAT, '123 франка'],
                [123, Currency::LIRA, MoneySpeller::SHORT_FORMAT, '123 лиры'],
                [256.4, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '256 рублей 40 копеек'],
                [65536.4, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '65536 рублей 40 копеек'],
                [16777216.4, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '16777216 рублей 40 копеек'],
                [4294967296.4, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '4294967296 рублей 40 копеек'],
                [4294967297.4, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '4294967297 рублей 40 копеек'],
                [
                    4294967296.4,
                    Currency::RUBLE,
                    MoneySpeller::DUPLICATION_FORMAT,
                    'четыре миллиарда двести девяносто четыре миллиона девятьсот шестьдесят семь тысяч двести девяносто шесть (4294967296) рублей сорок (40) копеек',
                ],
            ];
    }

    /**
     *
     * @throws \Exception
     */
    public function testSpellInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);
        MoneySpeller::spell(1, 'Invalid-Currency');
    }
}
