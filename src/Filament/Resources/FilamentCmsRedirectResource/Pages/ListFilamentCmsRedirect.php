<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsRedirectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsRedirectResource;

class ListFilamentCmsRedirect extends ListRecords
{
    protected static string $resource = FilamentCmsRedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
