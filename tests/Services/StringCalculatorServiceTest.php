<?php

namespace Tests\Services;

use App\Events\StringCalculatorServiceAddOccurred;
use App\Exceptions\StringCalculatorServiceException;
use App\Services\StringCalculatorService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

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
     * @test
     */
    public function it_should_get_add_called_count()
    {
        $this->givenNumbers('1');
        $this->givenNumbers('1,2');
        $this->givenNumbers('1,2,3,4,5');
        $calledCount = $this->stringCalculatorService->getCalledCount();
        $this->assertEquals(3, $calledCount);
    }

    /**
     * @test
     */
    public function it_should_trigger_event_after_calling_add()
    {
        Event::fake();

        $this->givenNumbers('1');
        $this->givenNumbers('1,2');
        $this->givenNumbers('1,2,3,4,5');

        Event::assertDispatchedTimes(StringCalculatorServiceAddOccurred::class, 3);
    }

    /**
     * @test
     */
    public function it_should_get_sum_except_greater_or_equal_than_one_thousand_numbers()
    {
        $this->givenNumbers('1,2,1000,1001');
        $this->sumShouldBe(3);
    }

    /**
     * @test
     */
    public function it_should_get_sum_when_using_any_length_delimiters()
    {
        $this->givenNumbers('//[***]\n1***2***3');
        $this->sumShouldBe(6);
    }

    /**
     * @test
     */
    public function it_should_get_sum_when_using_multiple_delimiters()
    {
        $this->givenNumbers('//[*][%]\n1*2%3');
        $this->sumShouldBe(6);
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
        parent::setUp();
    }
}
