<?php

namespace WebduoNederland\FilamentCms;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Outerweb\FilamentTranslatableFields\Filament\Plugins\FilamentTranslatableFieldsPlugin;

class FilamentCmsPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        /** @var string $path */
        $path = config('filament-cms.path', '/cms');

        /** @var array $supportedLocales */
        $supportedLocales = config('filament-cms.multi_languages', []);

        return $panel
            ->id('filament-cms')
            ->path($path)
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: __DIR__.'/../src/Filament/Resources', for: 'WebduoNederland\\FilamentCms\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/../src/Filament/Pages', for: 'WebduoNederland\\FilamentCms\\Filament\\Pages')
            ->discoverWidgets(in: __DIR__.'/../src/Filament/Widgets', for: 'WebduoNederland\\FilamentCms\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentTranslatableFieldsPlugin::make()
                    ->supportedLocales($supportedLocales),
            ])
            ->authGuard('filament-cms');
    }
}
