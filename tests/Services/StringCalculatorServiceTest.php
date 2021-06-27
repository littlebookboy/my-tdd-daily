<?php

namespace Tests\Services;

use App\Services\StringCalculatorService;
use PHPUnit\Framework\TestCase;

class StringCalculatorServiceTest extends TestCase
{
    public function test_add_empty_string_got_zero()
    {
        $stringCalculatorService = new StringCalculatorService();
        $sum = $stringCalculatorService->add('');
        $this->assertEquals(0, $sum);
    }

}
