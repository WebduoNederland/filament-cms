<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource;

class EditFilamentCmsNavigationItem extends EditRecord
{
    protected static string $resource = FilamentCmsNavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
