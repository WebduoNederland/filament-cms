<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsPageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsPageResource;

class ListFilamentCmsPage extends ListRecords
{
    protected static string $resource = FilamentCmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
