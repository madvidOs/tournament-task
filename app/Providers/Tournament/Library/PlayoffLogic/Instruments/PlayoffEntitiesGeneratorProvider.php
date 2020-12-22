<?php

namespace App\Providers\Tournament\Library\PlayoffLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffEntitiesGenerator as Model;

class PlayoffEntitiesGeneratorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Model::class, function ($app) {
            return new Model();    
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
