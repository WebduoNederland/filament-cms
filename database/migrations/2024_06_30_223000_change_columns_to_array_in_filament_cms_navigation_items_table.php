<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use WebduoNederland\FilamentCms\Models\FilamentCmsNavigationItem;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filament_cms_navigation_items', function (Blueprint $table): void {
            $table->renameColumn('name', 'name_old');
            $table->renameColumn('value', 'value_old');
        });

        Schema::table('filament_cms_navigation_items', function (Blueprint $table): void {
            $table->after('id', function (Blueprint $table): void {
                $table->json('name')->default(new Expression('(JSON_ARRAY())'));
                $table->json('slug')->default(new Expression('(JSON_ARRAY())'));
            });
        });

        FilamentCmsNavigationItem::query()
            ->get()
            ->each(function (FilamentCmsNavigationItem $filamentCmsNavigationItem): void {
                $filamentCmsNavigationItem->timestamps = false;

                $filamentCmsNavigationItem->name = [
                    config('filament-cms.multi_language_default') => $filamentCmsNavigationItem->getRawOriginal('name_old'),
                ];

                $filamentCmsNavigationItem->slug = [
                    config('filament-cms.multi_language_default') => $filamentCmsNavigationItem->getRawOriginal('value_old'),
                ];

                $subItems = $filamentCmsNavigationItem->sub_items;

                foreach ($subItems as &$subItem) {
                    $subItem['name'] = [
                        config('filament-cms.multi_language_default') => $subItem['name'],
                    ];

                    $subItem['slug'] = [
                        config('filament-cms.multi_language_default') => $subItem['value'],
                    ];

                    unset($subItem['value']);
                    unset($subItem['sub_item_type']);
                }

                $filamentCmsNavigationItem->sub_items = $subItems;

                $filamentCmsNavigationItem->save();
            });

        Schema::table('filament_cms_navigation_items', function (Blueprint $table): void {
            $table->dropColumn([
                'type',
                'name_old',
                'value_old',
            ]);
        });
    }
};
