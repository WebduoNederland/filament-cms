<?php

namespace WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource;

class CreateFilamentCmsNavigationItem extends CreateRecord
{
    protected static string $resource = FilamentCmsNavigationItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! array_key_exists('sub_items', $data)) {
            $data['sub_items'] = [];
        }

        return $data;
    }
}
