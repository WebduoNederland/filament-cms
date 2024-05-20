<?php

namespace WebduoNederland\FilamentCms\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use WebduoNederland\FilamentCms\Models\FilamentCmsAdmin;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;
use WebduoNederland\FilamentCms\Models\FilamentCmsRedirect;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('filament-cms::filament.statistics.pages_amount'), FilamentCmsPage::query()->count()),
            Stat::make(__('filament-cms::filament.statistics.redirects_amount'), FilamentCmsRedirect::query()->count()),
            Stat::make(__('filament-cms::filament.statistics.admins_amount'), FilamentCmsAdmin::query()->count()),
        ];
    }
}
