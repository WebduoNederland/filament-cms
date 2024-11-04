<?php

namespace WebduoNederland\FilamentCms\Observers;

use WebduoNederland\FilamentCms\Jobs\GenerateSitemapJob;
use WebduoNederland\FilamentCms\Models\FilamentCmsBlog;

class FilamentCmsBlogObserver
{
    public function created(FilamentCmsBlog $filamentCmsBlog): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function updated(FilamentCmsBlog $filamentCmsBlog): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function deleted(FilamentCmsBlog $filamentCmsBlog): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function restored(FilamentCmsBlog $filamentCmsBlog): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function forceDeleted(FilamentCmsBlog $filamentCmsBlog): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }
}
