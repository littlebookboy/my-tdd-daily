<?php

namespace Tests\Services;

use App\Services\StringCalculatorService;
use PHPUnit\Framework\TestCase;

class StringCalculatorServiceTest extends TestCase
{
    private $stringCalculatorService;

    public function test_add_empty_string_got_zero()
    {
        $sum = $this->stringCalculatorService->add('');
        $this->assertEquals(0, $sum);
    }


    public function test_add_one_got_one()
    {
        $sum = $this->stringCalculatorService->add('1');
        $this->assertEquals(1, $sum);
    }


    protected function setUp(): void
    {
        $this->stringCalculatorService = new StringCalculatorService();
    }
}
