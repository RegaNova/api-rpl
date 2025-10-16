<?php

namespace App\Providers;

use App\Interfaces\DevisionInterface;
use Illuminate\Http\Request;
use App\Interfaces\PositionInterface;
use Illuminate\Support\Facades\Route;
use App\Interfaces\GenerationInterface;
use App\Repositories\DevisionRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PositionRepository;
use Illuminate\Cache\RateLimiting\Limit;
use App\Repositories\GenerationRepository;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindings = [
            GenerationInterface::class => GenerationRepository::class,
            PositionInterface::class => PositionRepository::class,
            DevisionInterface::class => DevisionRepository::class
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
