<?php

namespace WebduoNederland\FilamentCms\Observers;

use WebduoNederland\FilamentCms\Jobs\GenerateSitemapJob;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

class FilamentCmsPageObserver
{
    public function created(FilamentCmsPage $filamentCmsPage): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function updated(FilamentCmsPage $filamentCmsPage): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function deleted(FilamentCmsPage $filamentCmsPage): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function restored(FilamentCmsPage $filamentCmsPage): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }

    public function forceDeleted(FilamentCmsPage $filamentCmsPage): void
    {
        if (config('filament-cms.sitemap_enabled', true)) {
            GenerateSitemapJob::dispatch();
        }
    }
}
