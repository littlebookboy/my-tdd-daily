<?php

namespace Tests\Services;

use App\Services\StringCalculatorService;
use PHPUnit\Framework\TestCase;

class StringCalculatorServiceTest extends TestCase
{
    private $stringCalculatorService;
    private $sum;

    public function test_add_empty_string_got_zero()
    {
        $this->givenNumbers('');
        $this->sumShouldBe(0);
    }

    public function test_add_one_got_one()
    {
        $this->givenNumbers('1');
        $this->sumShouldBe(1);
    }

    /**
     * @param string $numbers
     * @return void
     */
    public function givenNumbers(string $numbers): void
    {
        $this->sum = $this->stringCalculatorService->add($numbers);
    }

    public function sumShouldBe($expected): void
    {
        $this->assertEquals($expected, $this->sum);
    }

    protected function setUp(): void
    {
        $this->stringCalculatorService = new StringCalculatorService();
    }
}
