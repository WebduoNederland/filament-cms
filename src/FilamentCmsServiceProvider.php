<?php

namespace WebduoNederland\FilamentCms;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
            ->bootTranslations()
            ->bootViews()
            ->bootLivewire()
            ->bootRoutes();
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

    protected function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-cms');

        return $this;
    }

    protected function bootLivewire(): self
    {
        Livewire::component('filament-cms::base-page', \WebduoNederland\FilamentCms\Http\Livewire\BasePage::class);
        Livewire::component('filament-cms::simple-text', \WebduoNederland\FilamentCms\Http\Livewire\Components\SimpleText::class);
        Livewire::component('filament-cms::blog-post', \WebduoNederland\FilamentCms\Http\Livewire\Components\BlogPost::class);

        return $this;
    }

    protected function bootRoutes(): self
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

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
