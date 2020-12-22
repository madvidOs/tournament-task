<?php

namespace App\Providers\Tournament\Library\DivisionsLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBPreparation as Model;

class DivisionsDataDBPreparationProvider extends ServiceProvider
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
