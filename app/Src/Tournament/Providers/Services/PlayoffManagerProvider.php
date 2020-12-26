<?php

namespace App\Src\Tournament\Providers\Services;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\PlayoffManager;
use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder;

class PlayoffManagerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlayoffManager::class, function ($app) {
            return new PlayoffManager(
                $app->make(InfoBuilder::class)
            );
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
