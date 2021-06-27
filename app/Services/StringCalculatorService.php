<?php

namespace App\Services;

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

        if ($this->isTwoMoreNumbers($numbers)) {
            return $this->sum($numbers);
        }

        return $numbers;
    }

    /**
     * @param string $numbers
     * @return bool
     */
    public function isTwoMoreNumbers(string $numbers): bool
    {
        $this->delimiter = ',';
        if (strpos($numbers, '//') !== false) {
            $numbersSplitByNewLine = explode('\n', $numbers);
            $this->delimiter = str_replace('//', '', $numbersSplitByNewLine[0]);
        }
        return strpos($numbers, $this->delimiter) !== false;
    }

    /**
     * @param string $numbers
     * @return false|string[]
     */
    public function splitNumbers(string $numbers)
    {
        if (strpos($numbers, '//') !== false) {
            $numbersSplitByNewLine = explode('\n', $numbers);
            $numbers = $numbersSplitByNewLine[1];
        }
        $numbers = str_replace('\n', $this->delimiter, $numbers);
        $numbers = explode($this->delimiter, $numbers);
        return $numbers;
    }

    /**
     * @param string $numbers
     * @return int
     */
    public function sum(string $numbers)
    {
        $numbers = $this->splitNumbers($numbers);
        $sum = 0;
        foreach ($numbers as $number) {
            $sum += $number;
        }
        return $sum;
    }
}
