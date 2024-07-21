<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsBlogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsBlogResource;

class ListFilamentCmsBlog extends ListRecords
{
    protected static string $resource = FilamentCmsBlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
