<?php


namespace App\Interfaces;


interface INotify
{
    public function notify(\Exception $exception): string;
}