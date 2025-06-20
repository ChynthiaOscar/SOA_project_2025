<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class NamekoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */    public function register()
    {
        $this->app->singleton('nameko.client', function ($app) {
            // Default gateway URL from config
            $gatewayUrl = config('services.nameko.gateway_url', 'http://localhost:8000');
            
            // Api prefix from config or default to 'api/'
            $apiPrefix = config('services.nameko.api_prefix', 'api/');
            
            return new \App\Services\NamekoClient($gatewayUrl, $apiPrefix);
        });
        
        // Bind the NamekoClient to be resolved from the container
        $this->app->bind(\App\Services\NamekoClient::class, function ($app) {
            return $app->make('nameko.client');
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
