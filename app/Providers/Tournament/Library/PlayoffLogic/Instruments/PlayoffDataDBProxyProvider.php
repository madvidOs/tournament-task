<?php

namespace App\Providers\Tournament\Library\PlayoffLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Tournament\PlayoffLogic\Instruments\PlayoffDataDBProxy as Model;
use App\Repositories\Tournament\DivisionRepository;
use App\Repositories\Tournament\DivisionTeamRepository;

class PlayoffDataDBProxyProvider extends ServiceProvider
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
                $app->make(DivisionRepository::class),
                $app->make(DivisionTeamRepository::class),
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
