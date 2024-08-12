<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\GitHub;
use App\Services\GitHub\GitHubService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
        $this->app->bind(
            abstract: GitHub::class,
            concrete: fn (): GitHub => new GitHubService(
                token: config('services.github.token'),
            )
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
