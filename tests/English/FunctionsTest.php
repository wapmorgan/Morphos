<?php

namespace morphos\test\English;

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function testPluralize()
    {
        $this->assertEquals('10 messages', \morphos\English\pluralize(10, 'message'));
    }
}
