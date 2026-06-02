<?php

namespace WebduoNederland\FilamentCms\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -100;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-m-home';

    protected static ?string $navigationLabel = 'Dashboard';
}
