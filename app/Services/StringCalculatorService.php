<?php

namespace App\Services;

use Yish\Generators\Foundation\Service\Service;

class StringCalculatorService
{
    protected $repository;

    //
    public function add(string $numbers): int
    {
        if (!empty($numbers)) {
            if (strpos($numbers, ',') !== false) {
                $numbers = explode(',', $numbers);
                return $numbers[0] + $numbers[1];
            }
            return $numbers;
        }
        return 0;
    }
}
