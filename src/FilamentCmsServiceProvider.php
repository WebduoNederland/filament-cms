<?php

namespace WebduoNederland\FilamentCms;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class FilamentCmsServiceProvider extends ServiceProvider
{
    /**
     * Boot
     */
    public function boot(): void
    {
        $this
            ->bootAuthGuard()
            ->bootConfig()
            ->bootMigrations()
            ->bootCommands()
            ->bootTranslations();
    }

    protected function bootAuthGuard(): self
    {
        Config::set('auth.guards.filament-cms', [
            'driver' => 'session',
            'provider' => 'filament-cms',
        ]);

        Config::set('auth.providers.filament-cms', [
            'driver' => 'eloquent',
            'model' => \WebduoNederland\FilamentCms\Models\FilamentCmsAdmin::class,
        ]);

        return $this;
    }

    protected function bootConfig(): self
    {
        $this->publishes([
            __DIR__.'/../config/filament-cms.php' => config_path('filament-cms.php'),
        ], 'config');

        return $this;
    }

    protected function bootMigrations(): self
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    protected function bootCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \WebduoNederland\FilamentCms\Console\Commands\CreateUserCommand::class,
            ]);
        }

        return $this;
    }

    protected function bootTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-cms');

        return $this;
    }

    /**
     * Register
     */
    public function register(): void
    {
        $this
            ->registerConfig();
    }

    protected function registerConfig(): self
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-cms.php', 'filament-cms');

        return $this;
    }
}
