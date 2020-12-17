<?php

namespace App\Providers\Tournament;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Tournament\PlayoffWinnerRepository;

class PlayoffWinnerRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlayoffWinnerRepository::class, function ($app) {
            return new PlayoffWinnerRepository();
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
