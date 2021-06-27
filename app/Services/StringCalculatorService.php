<?php

namespace App\Services;

use App\Exceptions\StringCalculatorServiceException;

class StringCalculatorService
{
    protected $repository;
    private $delimiter;

    /**
     * @param string $numbers
     * @return int
     */
    public function add(string $numbers): int
    {
        if (empty($numbers)) {
            return 0;
        }

        if ($this->isMoreThanTwoNumbers($numbers)) {
            $numbers = $this->splitNumbers($numbers);
        } else {
            $numbers = [$numbers];
        }

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
        $this->delimiter = $this->delimiter($numbers);

        return strpos($numbers, $this->delimiter) !== false;
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
        $numbers = str_replace('\n', $this->delimiter, $numbers);
        $numbers = explode($this->delimiter, $numbers);
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
     * @return string
     */
    private function delimiter(string $numbers): string
    {
        $delimiter = ',';

        if ($this->isDifferentDelimiter($numbers)) {
            $numbersSplitByNewLine = explode('\n', $numbers);
            $delimiter = str_replace('//', '', $numbersSplitByNewLine[0]);
        }

        return $delimiter;
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
}
