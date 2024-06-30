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
            $table->renameColumn('meta_title', 'meta_title_old');
            $table->renameColumn('meta_description', 'meta_description_old');
        });

        Schema::table('filament_cms_pages', function (Blueprint $table): void {
            $table->after('status', function (Blueprint $table): void {
                $table->json('meta_title')->default(new Expression('(JSON_ARRAY())'));
                $table->json('meta_description')->default(new Expression('(JSON_ARRAY())'));
            });
        });

        FilamentCmsPage::query()
            ->get()
            ->each(function (FilamentCmsPage $filamentCmsPage): void {
                $filamentCmsPage->timestamps = false;

                $filamentCmsPage->meta_title = [
                    config('filament-cms.multi_language_default') => $filamentCmsPage->getRawOriginal('meta_title_old'),
                ];

                $filamentCmsPage->meta_description = [
                    config('filament-cms.multi_language_default') => $filamentCmsPage->getRawOriginal('meta_description_old'),
                ];

                $filamentCmsPage->save();
            });

        Schema::table('filament_cms_pages', function (Blueprint $table): void {
            $table->dropColumn([
                'meta_title_old',
                'meta_description_old',
            ]);
        });
    }
};
