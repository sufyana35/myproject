<?php

namespace App\Tests\Service;

use App\Service\NumberFormatter;
use PHPUnit\Framework\TestCase;

class NumberFormatterTest extends TestCase
{
    public function testNumberFormatter()
    {
        $numberForamtter = new NumberFormatter();
        $numberForamtter = $numberForamtter->numberFormatter('$5.55');
        $this->assertSame('5.55', $numberForamtter);
        //expected to pass
    }
}
