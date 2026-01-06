<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Interfaces\AuthInterface;
use App\Interfaces\BaseInterface;
use App\Repositories\AuthRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindings = [
            BaseInterface::class => BaseRepository::class,
            AuthInterface::class => AuthRepository::class,
        ];

        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(config('app.maximal_request', 60))
                ->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
