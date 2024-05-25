<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $value
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
            'has_sub_items' => 'boolean',
            'sub_items' => 'array',
        ];
    }
}
