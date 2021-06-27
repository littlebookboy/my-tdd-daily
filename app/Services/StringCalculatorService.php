<?php

namespace App\Services;

use Yish\Generators\Foundation\Service\Service;

class StringCalculatorService
{
    protected $repository;

    //
    public function add(string $numbers): int
    {
        if (empty($numbers)) {
            return 0;
        }

        if ($this->isTwoNumbers($numbers)) {
            $numbers = $this->splitNumbers($numbers);
            return $numbers[0] + $numbers[1];
        }

        return $numbers;
    }

    /**
     * @param string $numbers
     * @return bool
     */
    public function isTwoNumbers(string $numbers): bool
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
}
