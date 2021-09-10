<?php

namespace App\Providers;

use Facebook\Facebook;
use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Facebook::class, function ($app) {
            $config =config('services.facebook');
            return new Facebook([
                'app_app' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v2.6'
            ]);
        });
    }
}
