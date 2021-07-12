<?php


namespace App\Interfaces;


interface ILoggerService
{
    /**
     * @param string $log
     * @param string $level
     */
    public function write(string $log, string $level = 'debug'): void;
}