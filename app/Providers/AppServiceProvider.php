<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Nameko client configuration from the .env file
        $this->app->singleton('nameko.config', function ($app) {
            return [
                'gateway_url' => env('NAMEKO_GATEWAY_URL', 'http://localhost:8000')
            ];
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
