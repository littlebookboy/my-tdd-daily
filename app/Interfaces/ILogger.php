<?php


namespace App\Interfaces;


interface ILogger
{
    public function write($level = 'debug');
}