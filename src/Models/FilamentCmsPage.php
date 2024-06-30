<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;

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
class FilamentCmsPage extends Model
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
}
