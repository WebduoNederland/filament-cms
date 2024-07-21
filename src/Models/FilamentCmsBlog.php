<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
class FilamentCmsBlog extends Model
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
}
