<?php

namespace App\Providers;

use App\Interfaces\ILoggerService;
use App\Interfaces\INotify;
use App\Services\LaravelLoggerService;
use App\Services\LoggerNotifyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ILoggerService::class, LaravelLoggerService::class);
        $this->app->singleton(INotify::class, LoggerNotifyService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
