<?php

namespace App\Providers\Tournament;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Tournament\PlayoffParticipantRepository as Model;

class PlayoffParticipantRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Model::class, function ($app) {
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
