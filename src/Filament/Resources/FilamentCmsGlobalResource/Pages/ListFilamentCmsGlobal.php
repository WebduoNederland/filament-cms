<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsGlobalResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsGlobalResource;

class ListFilamentCmsGlobal extends ListRecords
{
    protected static string $resource = FilamentCmsGlobalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
