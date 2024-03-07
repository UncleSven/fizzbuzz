<?php

declare(strict_types = 1);

namespace App\Providers;

use Domain\FizzBuzz\DefaultConstraint;
use Domain\FizzBuzz\DefaultStrategy;
use Domain\FizzBuzz\FizzBuzzStrategy;
use Domain\Shared\TypeCaster;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(abstract: FizzBuzzStrategy::class, concrete: static function (): FizzBuzzStrategy {
            return new DefaultStrategy(
                new DefaultConstraint(3, 'Fizz', new DefaultConstraint(5, 'FizzBuzz')),
                new DefaultConstraint(5, 'Buzz'),
            );
        });

        $this->app->singleton(abstract: TypeCaster::class, concrete: TypeCaster::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
