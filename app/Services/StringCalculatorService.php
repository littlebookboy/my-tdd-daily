<?php

namespace App\Services;

use App\Events\StringCalculatorServiceAddOccurred;
use App\Exceptions\StringCalculatorServiceException;

class StringCalculatorService
{
    protected $repository;
    private $delimiters;
    private $addCalledCount = 0;

    /**
     * @param string $numbers
     * @return int
     */
    public function add(string $numbers): int
    {
        $this->updateAddCallingCounter();

        $this->triggerStringCalculatorServiceAddOccurredEvent();

        if (empty($numbers)) {
            return 0;
        }

        if ($this->isMoreThanTwoNumbers($numbers)) {
            $numbers = $this->splitNumbers($numbers);
        } else {
            $numbers = [$numbers];
        }

        $numbers = $this->getLessThanOneThousandNumbers($numbers);

        $this->throwExceptionWhenNumberIsNegative($numbers);

        return $this->sum($numbers);
    }

    /**
     * @param array $numbers
     * @return int
     */
    private function sum(array $numbers): int
    {
        $sum = 0;
        foreach ($numbers as $number) {
            $sum += $number;
        }
        return $sum;
    }

    /**
     * @param string $numbers
     * @return bool
     */
    private function isMoreThanTwoNumbers(string $numbers): bool
    {
        $this->delimiters = $this->delimiter($numbers);

        return strpos($numbers, $this->delimiters[0]) !== false;
    }

    /**
     * @param string $numbers
     * @return array
     */
    private function splitNumbers(string $numbers): array
    {
        if ($this->isDifferentDelimiter($numbers)) {
            $numbersSplitByNewLine = explode('\n', $numbers);
            $numbers = $numbersSplitByNewLine[1];
        }
        $numbers = str_replace('\n', $this->delimiters[0], $numbers);
        $numbers = explode($this->delimiters[0], $numbers);
        return $numbers;
    }

    /**
     * @param string $numbers
     * @return bool
     */
    private function isDifferentDelimiter(string $numbers): bool
    {
        return strpos($numbers, '//') !== false;
    }

    /**
     * @param string $numbers
     * @return array
     */
    private function delimiter(string $numbers): array
    {
        $delimiters = [','];

        if ($this->isDifferentDelimiter($numbers)) {
            $numbersSplitByNewLine = explode('\n', $numbers);
            $delimiters = [str_replace('//', '', $numbersSplitByNewLine[0])];
            if ($this->isDelimiterSpecifyByBrackets($delimiters[0])) {
                $delimiters[0] = [substr($delimiters[0], 1, -1)];
            }
        }

        return $delimiters;
    }

    /**
     * @param array $numbers
     * @throws \Throwable
     */
    private function throwExceptionWhenNumberIsNegative(array $numbers): void
    {
        $negativeNumbers = [];
        foreach ($numbers as $number) {
            if ($number < 0) {
                $negativeNumbers[] = $number;
            }
        }

        $exceptionMessage = count($negativeNumbers) > 1
            ? "negatives not allowed : " . join($negativeNumbers, ",")
            : "negatives not allowed";

        throw_if(
            !empty($negativeNumbers),
            StringCalculatorServiceException::class,
            $exceptionMessage
        );
    }

    /**
     * @return int
     */
    public function getCalledCount(): int
    {
        return $this->addCalledCount;
    }

    private function updateAddCallingCounter(): void
    {
        $this->addCalledCount++;
    }

    private function triggerStringCalculatorServiceAddOccurredEvent(): void
    {
        event(StringCalculatorServiceAddOccurred::class);
    }

    /**
     * @param array $numbers
     * @return array
     */
    private function getLessThanOneThousandNumbers(array $numbers): array
    {
        $numbers = array_filter($numbers, function ($number) {
            return $number < 1000;
        });
        return $numbers;
    }

    /**
     * @param $delimiter
     * @return bool
     */
    private function isDelimiterSpecifyByBrackets($delimiter): bool
    {
        return substr($delimiter, 0, 1) === '[' &&
            substr($delimiter, -1) === ']';
    }
}
