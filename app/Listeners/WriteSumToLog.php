<?php

namespace App\Listeners;

use App\Events\StringWasAdded;
use App\Interfaces\ILoggerService;
use App\Interfaces\INotify;

class WriteSumToLog
{
    /**
     * @var ILoggerService
     */
    private $loggerService;
    /**
     * @var INotify
     */
    private $notifyService;

    /**
     * WriteSumToLog constructor.
     * @param ILoggerService $loggerService
     * @param INotify $notifyService
     */
    public function __construct(ILoggerService $loggerService, INotify $notifyService)
    {
        $this->loggerService = $loggerService;
        $this->notifyService = $notifyService;
    }

    /**
     * Handle the event.
     *
     * @param StringWasAdded $event
     * @return void
     */
    public function handle(StringWasAdded $event)
    {
        try {
            $this->loggerService->write($event->sum);
        } catch (\Exception $exception) {
            $this->notifyService->notify($exception);
        }
    }
}
