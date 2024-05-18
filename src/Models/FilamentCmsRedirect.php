<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $from_slug
 * @property string $to
 * @property string $type
 * @property int $hits
 * @property ?Carbon $last_hit
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class FilamentCmsRedirect extends Model
{
    protected $guarded = [
        //
    ];

    protected function casts(): array
    {
        return [
            'last_hit' => 'datetime',
        ];
    }
}
