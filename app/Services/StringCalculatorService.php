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
            return $numbers;
        }
        return 0;
    }
}
