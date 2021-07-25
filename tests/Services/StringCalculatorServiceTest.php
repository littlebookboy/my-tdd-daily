<?php

namespace Tests\Services;

use App\Events\StringWasAdded;
use App\Exceptions\StringCalculatorServiceException;
use App\Interfaces\ILoggerService;
use App\Interfaces\INotify;
use App\Services\StringCalculatorService;
use Exception;
use Illuminate\Support\Facades\Event;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * Class StringCalculatorServiceTest
 * @package Tests\Services
 * @group StringCalculatorServiceTest
 */
class StringCalculatorServiceTest extends TestCase
{
    /**
     * @var StringCalculatorService
     */
    private $stringCalculatorService;

    /**
     * @var string
     */
    private $numbers = '';

    /**
     * @var int
     */
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
            $this->sumShouldBeThrowException();
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
            $this->sumShouldBeThrowException();
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
        $this->sumShouldBe(1);

        $this->givenNumbers('1,2');
        $this->sumShouldBe(3);

        $this->givenNumbers('1,2,3,4,5');
        $this->sumShouldBe(15);

        $calledCount = $this->stringCalculatorService->getCalledCount();
        $this->assertEquals(3, $calledCount);
    }

    /**
     * @test
     */
    public function it_should_trigger_event_after_calling_add()
    {
        Event::fake();

        $this->stringCalculatorService->add('');
        $this->stringCalculatorService->add('');
        $this->stringCalculatorService->add('');

        Event::assertDispatchedTimes(StringWasAdded::class, 3);
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
     * @test
     * @dataProvider longerMultipleDelimitersProvider
     */
    public function it_should_get_sum_more_testcases($numbers, $excepted)
    {
        $this->givenNumbers($numbers);
        $this->sumShouldBe($excepted);
    }

    public function longerMultipleDelimitersProvider()
    {
        return [
            ['//[**][%%]\n1**2%%3', 6],
            ['//[zzz][@@]\n10zzz5@@1@@3', 19],
            ['//[jkjk][@@]\n100jkjk800@@100jkjk55', 1055],
        ];
    }

    /**
     * @test
     * 嘗試不同的測試案例命名方式
     */
    public function CallAdd_LogFailAndThrowException_GetExceptionMessageLogFail()
    {
        // stub: When calling Add() and the logger throws an exception
        $this->instance(ILoggerService::class, new StubLoggerService());
        $stubLoggerService = $this->app->make(ILoggerService::class);
        $stubLoggerService->toThrow = true;

        // mock: call notify() when writing log fail.
        $this->mock(INotify::class)
            ->shouldReceive('notify')
            ->once();

        $this->stringCalculatorService->add('');
    }

    /**
     * @test
     */
    public function it_should_logged_sum_when_call_add()
    {
        // mock
        $this->mockLoggerInterface()
            ->shouldReceive()
            ->write('1')
            ->once();

        $this->givenNumbers('1');

        $this->stringCalculatorService->add($this->numbers); // add() called
    }

    /**
     * @param string $numbers
     * @return void
     */
    public function givenNumbers(string $numbers): void
    {
        $this->numbers = $numbers;
    }

    public function sumShouldBe($expected): void
    {
        $this->sum = $this->stringCalculatorService->add($this->numbers);

        $this->assertEquals($expected, $this->sum);
    }

    public function sumShouldBeThrowException(): void
    {
        $this->stringCalculatorService->add($this->numbers);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->stringCalculatorService = $this->app->make(StringCalculatorService::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
        unset($this->stringCalculatorService);
    }

    /**
     * @return MockInterface
     */
    private function mockLoggerInterface(): MockInterface
    {
        return $this->mock(ILoggerService::class);
    }
}

class StubLoggerService implements ILoggerService
{
    public $toThrow = false;

    /**
     * @param string $log
     * @param string $level
     */
    public function write(string $log, string $level = 'info'): void
    {
        throw_if($this->toThrow, Exception::class);
    }
}
