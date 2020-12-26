<?php

namespace App\Src\Tournament\Providers\Services;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\DivisionsManager;
use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder;

class DivisionsManagerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DivisionsManager::class, function ($app) {
            return new DivisionsManager(
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
