<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsGlobalResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsGlobalResource;

class EditFilamentCmsGlobal extends EditRecord
{
    protected static string $resource = FilamentCmsGlobalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
