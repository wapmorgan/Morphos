<?php
namespace morphos\test\Russian;

require __DIR__.'/../../vendor/autoload.php';

use morphos\Gender;
use morphos\Currency;
use morphos\Russian\MoneySpeller;

class MoneySpellerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider moneyAmountsProvider()
     */
    public function testSpell($value, $currency, $format, $result)
    {
        $this->assertEquals($result, MoneySpeller::spell($value, $currency, $format));
    }

    public function moneyAmountsProvider()
    {
        return
        [
            [123.45, Currency::RUBLE, MoneySpeller::SHORT_FORMAT, '123 рубля 45 копеек'],
            [321.54, Currency::DOLLAR, MoneySpeller::NORMAL_FORMAT, 'триста двадцать один доллар пятьдесят четыре цента'],
            [369.12, Currency::EURO, MoneySpeller::DUPLICATION_FORMAT, 'триста шестьдесят девять (369) евро двенадцать (12) центов'],
            [246.35, Currency::YEN, MoneySpeller::CLARIFICATION_FORMAT, '246 (двести сорок шесть) иен 35 (тридцать пять) сенов'],
        ];
    }
}
