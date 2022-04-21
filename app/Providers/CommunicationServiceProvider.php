<?php

namespace App\Providers;

use App\Services\Communication\Contract\CommunicationProviderInterface;
use Illuminate\Support\ServiceProvider;
use \Facades\App\Services\Communication\Manager;

class CommunicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommunicationProviderInterface::class, function ($app) {
            return Manager::make(config('communication.default'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
