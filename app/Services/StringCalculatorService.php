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

        if ($this->isTwoMoreNumbers($numbers)) {
            $numbers = $this->splitNumbers($numbers);
            $sum = 0;
            foreach ($numbers as $number) {
                $sum += $number;
            }
            return $sum;
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
}
