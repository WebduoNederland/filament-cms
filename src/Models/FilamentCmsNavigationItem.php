<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property int $sort
 * @property bool $has_sub_items
 * @property array $sub_items
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class FilamentCmsNavigationItem extends Model
{
    protected $guarded = [
        //
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'slug' => 'array',
            'has_sub_items' => 'boolean',
            'sub_items' => 'array',
        ];
    }
}
