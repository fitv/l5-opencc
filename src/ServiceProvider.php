<?php

namespace Mvmx\OpenCC;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OpenCC::class, function () {
            return new OpenCC;
        });

        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/opencc.php', 'opencc'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/opencc.php' => config_path('opencc.php'),
        ], 'config');
    }
}
