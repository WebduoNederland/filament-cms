<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsPageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsPageResource;

class EditFilamentCmsPage extends EditRecord
{
    protected static string $resource = FilamentCmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
