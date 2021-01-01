<?php

namespace App\Src\Tournament\Providers\Services\DivisionsLogic;

use App\Src\Tournament\Services\DivisionsLogic\InfoAggregator;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy;
use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\DivisionsLogic\InfoBuilder as Model;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBPreparation;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\EntitiesGenerator;


class InfoBuilderProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            Model::class, 
            function ($app) {
                return new Model(
                    $app->make(DataDBProxy::class),
                    $app->make(EntitiesGenerator::class),
                    $app->make(DataDBPreparation::class),
                    $app->make(InfoAggregator::class),
                );
            }
        );
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
