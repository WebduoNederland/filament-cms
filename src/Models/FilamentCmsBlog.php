<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use WebduoNederland\FilamentCms\Observers\FilamentCmsBlogObserver;

/**
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property array $content
 * @property array $images
 * @property Carbon $publish_date
 * @property bool $published
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
#[ObservedBy(FilamentCmsBlogObserver::class)]
class FilamentCmsBlog extends Model implements Sitemapable
{
    protected $guarded = [
        //
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'slug' => 'array',
            'content' => 'array',
            'images' => 'array',
            'publish_date' => 'datetime',
            'published' => 'boolean',
        ];
    }

    public function toSitemapTag(): Url|string|array
    {
        if (config('filament-cms.multi_language_enabled', false)) {
            $urls = [];

            foreach ($this->slug as $slug) {
                $slug = str($slug)->prepend('blog/')->toString();

                $urls[] = Url::create(route('segments-page', ['segments' => $slug]))
                    ->setLastModificationDate(Carbon::create($this->updated_at ?? now())); // @phpstan-ignore-line
            }

            return $urls;
        }

        $slug = str($this->slug[config('filament-cms.multi_language_default', 'en')])->prepend('blog/')->toString();

        return Url::create(route('segments-page', ['segments' => $slug]))
            ->setLastModificationDate(Carbon::create($this->updated_at ?? now())); // @phpstan-ignore-line
    }
}
