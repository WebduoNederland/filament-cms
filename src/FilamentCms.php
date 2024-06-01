<?php

namespace WebduoNederland\FilamentCms;

use WebduoNederland\FilamentCms\Models\FilamentCmsGlobal;

class FilamentCms
{
    public static function global(string $name): ?array
    {
        /** @var ?FilamentCmsGlobal $global */
        $global = FilamentCmsGlobal::query()
            ->where('name', '=', $name)
            ->first();

        if (! $global) {
            return null;
        }

        if (count($global->data) === 1) {
            return $global->data[0];
        }

        return $global->data;
    }
}
