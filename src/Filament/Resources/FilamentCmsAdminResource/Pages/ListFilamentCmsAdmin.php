<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsAdminResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsAdminResource;

class ListFilamentCmsAdmin extends ListRecords
{
    protected static string $resource = FilamentCmsAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
