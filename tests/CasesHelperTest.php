<?php
namespace morphos\test;

use morphos\CasesHelper;
use morphos\Cases;

class CasesHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider casesProvider
     */
    public function testCanonizeCase($short, $case)
    {
        $this->assertEquals($case, CasesHelper::canonizeCase($short));
    }

    public function casesProvider()
    {
        return [
            ['nominativus', Cases::NOMINATIVE],
            ['genetivus', Cases::GENITIVE],
            ['dativus', Cases::DATIVE],
            ['ablativus', Cases::ABLATIVE],
            ['praepositionalis', Cases::PREPOSITIONAL],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCanonizeCaseInvalid()
    {
        CasesHelper::canonizeCase('Invalid-Case');
    }
}
