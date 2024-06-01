<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property array $data
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class FilamentCmsGlobal extends Model
{
    protected $guarded = [
        //
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
