<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TextSummarizationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TextSummarizationService::class, function ($app) {
            return new TextSummarizationService();
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
