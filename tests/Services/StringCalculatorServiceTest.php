<?php

namespace Tests\Services;

use App\Exceptions\StringCalculatorServiceException;
use App\Services\StringCalculatorService;
use PHPUnit\Framework\TestCase;

class StringCalculatorServiceTest extends TestCase
{
    private $stringCalculatorService;
    private $sum;

    /**
     * @test
     */
    public function it_should_get_zero_by_add_empty_string()
    {
        $this->givenNumbers('');
        $this->sumShouldBe(0);
    }

    /**
     * @test
     */
    public function it_should_get_sum_by_add_one_number()
    {
        $this->givenNumbers('1');
        $this->sumShouldBe(1);
    }

    /**
     * @test
     */
    public function it_should_get_sum_by_add_two_numbers()
    {
        $this->givenNumbers('1,2');
        $this->sumShouldBe(3);
    }

    /**
     * @test
     */
    public function it_should_get_sum_by_add_unknown_amount_numbers()
    {
        $this->givenNumbers(implode(',', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]));
        $this->sumShouldBe(55);
    }

    /**
     * @test
     */
    public function it_should_get_sum_by_new_line_numbers()
    {
        $this->givenNumbers('1\n2,3');
        $this->sumShouldBe(6);
    }

    /**
     * @test
     */
    public function it_should_get_sum_when_using_different_delimiters()
    {
        $this->givenNumbers('//;\n1;2');
        $this->sumShouldBe(3);
    }

    /**
     * @test
     */
    public function it_should_get_exception_by_negative_numbers()
    {
        $this->expectException(StringCalculatorServiceException::class);
//        $this->expectExceptionMessage("negatives not allowed");

        try {
            $this->givenNumbers('-1');
        } catch (StringCalculatorServiceException $exception) {
            $this->assertEquals("negatives not allowed", $exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @test
     */
    public function it_should_show_all_negative_numbers_when_two_more()
    {
        $this->expectException(StringCalculatorServiceException::class);
        // $this->expectExceptionMessage("negatives not allowed : -1,-2,-3");

        try {
            $this->givenNumbers('-1,-2,-3');
        } catch (StringCalculatorServiceException $exception) {
            $this->assertEquals("negatives not allowed : -1,-2,-3", $exception->getMessage());
            throw $exception;
        }
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
