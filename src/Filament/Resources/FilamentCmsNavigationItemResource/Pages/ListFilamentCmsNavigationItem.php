<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource;

class ListFilamentCmsNavigationItem extends ListRecords
{
    protected static string $resource = FilamentCmsNavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
