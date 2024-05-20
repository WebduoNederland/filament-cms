<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsAdminResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsAdminResource;

class EditFilamentCmsAdmin extends EditRecord
{
    protected static string $resource = FilamentCmsAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
