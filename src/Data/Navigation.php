<?php

namespace WebduoNederland\FilamentCms\Data;

use Illuminate\Support\Collection;
use WebduoNederland\FilamentCms\Models\FilamentCmsNavigationItem;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

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
                    'name' => $item->name,
                    'url' => self::getUrl($item->type, $item->value),
                    'sub_items' => $subItems->map(function (array $subItem): array {
                        return [
                            'name' => $subItem['name'],
                            'url' => self::getUrl($subItem['sub_item_type'], $subItem['value']),
                        ];
                    }),
                ];
            });
    }

    protected static function getUrl(string $type, string $value): string
    {
        if ($type === 'page') {
            return FilamentCmsPage::query()
                ->find($value)
                ?->slug ?? '#';
        } elseif ($type === 'slug') {
            return $value;
        }

        return '#';
    }
}
