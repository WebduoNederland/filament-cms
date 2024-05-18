<?php

namespace WebduoNederland\FilamentCms\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -100;

    protected static ?string $navigationIcon = 'heroicon-m-home';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static string $view = 'filament-panels::pages.dashboard';

    public function getWidgets(): array
    {
        return Filament::getWidgets();
    }

    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
