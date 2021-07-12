<?php

namespace App\Listeners;

use App\Events\StringWasAdded;
use App\Interfaces\ILoggerService;

class WriteSumToLog
{
    /**
     * @var ILoggerService
     */
    private $loggerService;

    /**
     * WriteSumToLog constructor.
     * @param ILoggerService $loggerService
     */
    public function __construct(ILoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    /**
     * Handle the event.
     *
     * @param StringWasAdded $event
     * @return void
     */
    public function handle(StringWasAdded $event)
    {
        $this->loggerService->write($event->sum);
    }
}
