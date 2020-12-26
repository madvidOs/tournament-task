<?php

namespace App\Src\Tournament\Providers\Services\PlayoffLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder as DivisionsInfoBuilder;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\DataDBProxy;
use App\Src\Tournament\Services\PlayoffLogic\Instruments\EntitiesGenerator;
use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\PlayoffLogic\InfoBuilder as Model;

class InfoBuilderProvider extends ServiceProvider
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
                $app->make(DivisionsInfoBuilder::class),
                $app->make(DataDBProxy::class),
                $app->make(EntitiesGenerator::class),
                $app->make(DataDBPreparation::class),
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
