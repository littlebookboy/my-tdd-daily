<?php

namespace App\Services;

class StringCalculatorService
{
    protected $repository;

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
        return strpos($numbers, ',') !== false;
    }

    /**
     * @param string $numbers
     * @return false|string[]
     */
    public function splitNumbers(string $numbers)
    {
        $numbers = explode(',', $numbers);
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
