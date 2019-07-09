<?php
namespace morphos\test;

use morphos\CurrenciesHelper;
use morphos\Currency;

class CurrenciesHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider currenciesProvider
     */
    public function testCanonizeCase($currency, array $shortcuts)
    {
        $this->assertEquals($currency, CurrenciesHelper::canonizeCurrency($currency));
        foreach ($shortcuts as $shortcut) {
            $this->assertEquals($currency, CurrenciesHelper::canonizeCurrency($shortcut));
        }
    }

    public function currenciesProvider()
    {
        return [
            [Currency::DOLLAR, ['$', 'usd', 'dollar']],
            [Currency::EURO, ['€', 'euro']],
            [Currency::YEN, ['¥']],
            [Currency::POUND, ['£']],
            [Currency::FRANC, ['Fr']],
            [Currency::YUAN, ['元']],
            [Currency::KRONA, ['Kr']],
            [Currency::PESO, []],
            [Currency::WON, ['₩']],
            [Currency::LIRA, ['₺']],
            [Currency::RUBLE, ['₽', 'ruble']],
            [Currency::RUPEE, ['₹']],
            [Currency::REAL, ['R$']],
            [Currency::RAND, ['R']],
            [Currency::HRYVNIA, ['₴']],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCanonizeCurrency()
    {
        CurrenciesHelper::canonizeCurrency('Invalid-Case');
    }
}
