<?php

namespace App\Providers\Tournament\Library\PlayoffLogic;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy;
use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\PlayoffLogic\PlayoffInfo as Model;

class PlayoffInfoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Model::class, function ($app) {
            return new Model(
                $app->make(DivisionsInfo::class),
                $app->make(PlayoffDataDBProxy::class),
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
