<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsBlogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsBlogResource;

class EditFilamentCmsBlog extends EditRecord
{
    protected static string $resource = FilamentCmsBlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
