<?php

namespace WebduoNederland\FilamentCms;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use WebduoNederland\FilamentCms\Console\Commands\CreateComponentCommand;
use WebduoNederland\FilamentCms\Console\Commands\CreateUserCommand;
use WebduoNederland\FilamentCms\Http\Livewire\BasePage;
use WebduoNederland\FilamentCms\Http\Livewire\Components\BlogPost;
use WebduoNederland\FilamentCms\Http\Livewire\Components\SimpleText;
use WebduoNederland\FilamentCms\Models\FilamentCmsAdmin;

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
            'model' => FilamentCmsAdmin::class,
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
                CreateUserCommand::class,
                CreateComponentCommand::class,
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
        Livewire::component('filament-cms.base-page', BasePage::class);
        Livewire::component('filament-cms.simple-text', SimpleText::class);
        Livewire::component('filament-cms.blog-post', BlogPost::class);

        return $this;
    }

    protected function bootRoutes(): self
    {
        $this->app->booted(function (): void {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

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
