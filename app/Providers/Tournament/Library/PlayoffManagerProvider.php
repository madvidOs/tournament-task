<?php

namespace App\Providers\Tournament\Library;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\PlayoffManager;
use App\Library\Services\Tournament\PlayoffLogic\PlayoffInfo;

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
                $app->make(PlayoffInfo::class)
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
