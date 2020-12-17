<?php

namespace App\Providers\Tournament\Library\DivisionsLogic;

use App\Library\Services\Tournament\DivisionsLogic\Instruments\DivisionsDataDBProxy;
use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\DivisionsLogic\DivisionsInfo as Model;

class DivisionsInfoProvider extends ServiceProvider
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
                $app->make(DivisionsDataDBProxy::class),
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
