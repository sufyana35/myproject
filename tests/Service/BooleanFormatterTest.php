<?php

namespace App\Tests\Service;

use App\Service\BooleanFormatter;
use PHPUnit\Framework\TestCase;

class BooleanFormatterTest extends TestCase
{
    public function testBooleanFormatter()
    {
        $booleanFormatter = new BooleanFormatter();
        $booleanFormatter = $booleanFormatter->booleanFormatter('');
        $this->assertSame('', $booleanFormatter);
        //expected to pass

        $booleanFormatter = new BooleanFormatter();
        $booleanFormatter = $booleanFormatter->booleanFormatter('yes');
        $this->assertSame(date('Y/m/d'), $booleanFormatter);
        //expected to pass

        $booleanFormatter = new BooleanFormatter();
        $booleanFormatter = $booleanFormatter->booleanFormatter('');
        $this->assertSame(date('Y/m/d'), $booleanFormatter);
        //expected to fail
    }
}
