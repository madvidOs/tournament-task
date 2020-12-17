<?php

namespace App\Providers\Tournament\Library;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\DivisionsManager;
use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;

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
                $app->make(DivisionsInfo::class)
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
