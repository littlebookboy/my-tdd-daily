<?php


namespace App\Services;


use App\Interfaces\ILoggerService;

class LaravelLoggerService implements ILoggerService
{
    /**
     * @param string $log
     * @param string $level
     */
    public function write(string $log, string $level = 'info'): void
    {
        if (function_exists($level)) {
            $level($log);
        } else {
            info($log);
        }
    }
}