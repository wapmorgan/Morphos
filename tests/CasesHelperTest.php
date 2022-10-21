<?php

namespace morphos\test;

use morphos\Cases;
use morphos\CasesHelper;
use PHPUnit\Framework\TestCase;

class CasesHelperTest extends TestCase
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

    public function testCanonizeCaseInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);
        CasesHelper::canonizeCase('Invalid-Case');
    }
}
