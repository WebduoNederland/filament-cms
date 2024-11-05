<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;
use WebduoNederland\FilamentCms\Observers\FilamentCmsPageObserver;

/**
 * @property int $id
 * @property string $name
 * @property array $slug
 * @property array $components
 * @property PageStatusEnum $status
 * @property array $meta_title
 * @property array $meta_description
 * @property ?string $meta_robots
 * @property ?string $meta_og_image
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
#[ObservedBy(FilamentCmsPageObserver::class)]
class FilamentCmsPage extends Model implements Sitemapable
{
    protected $guarded = [
        //
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'components' => 'array',
            'status' => PageStatusEnum::class,
            'meta_title' => 'array',
            'meta_description' => 'array',
        ];
    }

    public function toSitemapTag(): Url|string|array
    {
        if (config('filament-cms.multi_language_enabled', false)) {
            $urls = [];

            /** @var string $defaultMultiLang */
            $defaultMultiLang = config('filament-cms.multi_language_default', 'en');

            foreach ($this->slug as $lang => $slug) {
                if ($lang !== $defaultMultiLang) {
                    $slug = str($slug)->prepend($lang.'/')->toString();
                }

                $urls[] = Url::create(route('segments-page', ['segments' => $slug]))
                    ->setLastModificationDate(Carbon::create($this->updated_at ?? now())); // @phpstan-ignore-line
            }

            return $urls;
        }

        return Url::create(route('segments-page', ['segments' => $this->slug[config('filament-cms.multi_language_default', 'en')]]))
            ->setLastModificationDate(Carbon::create($this->updated_at ?? now())); // @phpstan-ignore-line
    }
}
