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

    public function test_add_two_got_sum()
    {
        $this->givenNumbers('1,2');
        $this->sumShouldBe(3);
    }

    public function test_add_unknown_numbers_got_sum()
    {
        $this->givenNumbers(implode(',', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]));
        $this->sumShouldBe(55);
    }

    public function test_add_handle_new_lines_numbers_string()
    {
        $this->givenNumbers('1\n2,3');
        $this->sumShouldBe(6);
    }

    public function test_support_different_delimiters()
    {
        $this->givenNumbers('//;\n1;2');
        $this->sumShouldBe(3);
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
