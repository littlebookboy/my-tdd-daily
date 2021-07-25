<?php


namespace App\Services;


use App\Interfaces\INotify;

class LoggerNotifyService implements INotify
{
    public function notify(\Exception $exception): string
    {
        return $exception->getMessage();
    }
}