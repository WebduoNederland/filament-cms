<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsRedirectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsRedirectResource;

class EditFilamentCmsRedirect extends EditRecord
{
    protected static string $resource = FilamentCmsRedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
