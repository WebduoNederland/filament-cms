<?php

namespace WebduoNederland\FilamentCms\Data;

use Illuminate\Support\Collection;
use WebduoNederland\FilamentCms\Models\FilamentCmsNavigationItem;

class Navigation
{
    public static function get(): Collection
    {
        return FilamentCmsNavigationItem::query()
            ->orderBy('sort')
            ->get()
            ->map(function (FilamentCmsNavigationItem $item): array {
                $subItems = collect($item->sub_items);

                return [
                    'name' => $item->name[getFilamentCmsLang()],
                    'url' => $item->slug[getFilamentCmsLang()],
                    'sub_items' => $subItems->map(function (array $subItem): array {
                        return [
                            'name' => $subItem['name'][getFilamentCmsLang()],
                            'url' => $subItem['slug'][getFilamentCmsLang()],
                        ];
                    }),
                ];
            });
    }
}
