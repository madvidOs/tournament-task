<?php

namespace App\Src\Tournament\Providers\Services\DivisionsLogic\Instruments;

use Illuminate\Support\ServiceProvider;
use App\Src\Tournament\Services\DivisionsLogic\Instruments\DataDBProxy as Model;
use App\Src\Tournament\Repositories\DivisionGameRepository;
use App\Src\Tournament\Repositories\DivisionPositionRepository;
use App\Src\Tournament\Repositories\DivisionRepository;
use App\Src\Tournament\Repositories\DivisionTeamRepository;

class DataDBProxyProvider extends ServiceProvider
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
                    $app->make(DivisionRepository::class),
                    $app->make(DivisionTeamRepository::class),
                    $app->make(DivisionGameRepository::class),
                    $app->make(DivisionPositionRepository::class),
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
