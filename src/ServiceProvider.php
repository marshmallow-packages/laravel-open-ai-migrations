<?php

namespace Marshmallow\LaravelOpenAiMigrations;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Marshmallow\LaravelOpenAiMigrations\Console\Commands\CreateMigrationCommand;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-open-ai-migrations.php' => config_path('laravel-open-ai-migrations.php'),
        ], 'laravel-open-ai-migrations');

        /*
         * Commands
         */
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateMigrationCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-open-ai-migrations.php',
            'laravel-open-ai-migrations'
        );
    }
}
