<?php

namespace App\Services;

use Yish\Generators\Foundation\Service\Service;

class StringCalculatorService
{
    protected $repository;

    //
    public function add(string $string): int
    {
        if (!empty($string)) {
            return $string;
        }
        return 0;
    }
}
