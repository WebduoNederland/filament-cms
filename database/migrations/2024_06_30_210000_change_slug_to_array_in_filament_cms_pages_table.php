<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filament_cms_pages', function (Blueprint $table): void {
            $table->dropIndex('filament_cms_pages_slug_index');
        });

        Schema::table('filament_cms_pages', function (Blueprint $table): void {
            $table->renameColumn('slug', 'slug_old');
        });

        Schema::table('filament_cms_pages', function (Blueprint $table): void {
            $table->json('slug')->default(new Expression('(JSON_ARRAY())'))->after('id');
        });

        FilamentCmsPage::query()
            ->get()
            ->each(function (FilamentCmsPage $filamentCmsPage): void {
                $filamentCmsPage->timestamps = false;

                $filamentCmsPage->slug = [
                    config('filament-cms.multi_language_default') => $filamentCmsPage->getRawOriginal('slug_old'),
                ];

                $filamentCmsPage->save();
            });

        Schema::table('filament_cms_pages', function (Blueprint $table): void {
            $table->dropColumn('slug_old');
        });
    }
};
