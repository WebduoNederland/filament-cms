<?php

namespace WebduoNederland\FilamentCms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Sitemap\Sitemap;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;
use WebduoNederland\FilamentCms\Models\FilamentCmsBlog;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(): void
    {
        $pages = FilamentCmsPage::query()
            ->where('status', '=', PageStatusEnum::Published->value)
            ->get();

        $blogs = collect();

        if (config('filament-cms.blogs_enabled', false)) {
            $blogs = FilamentCmsBlog::query()
                ->where('published', '=', true)
                ->get();
        }

        Sitemap::create()
            ->add($pages)
            ->add($blogs)
            ->writeToFile(public_path('sitemap.xml'));
    }
}
