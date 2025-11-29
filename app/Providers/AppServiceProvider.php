<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('web-global', function (Request $request): Limit {
            return Limit::perMinute(60)
                ->by($request->ip() ?? 'global')
                ->response(function () {
                    return response()->view('errors.rate-limit', status: 429);
                });
        });
    }
}
