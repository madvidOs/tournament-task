<?php

namespace App\Providers\Tournament\Library\PlayoffLogic;

use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBPreparation;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffEntitiesGenerator;
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
                $app->make(PlayoffEntitiesGenerator::class),
                $app->make(PlayoffDataDBPreparation::class),
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
