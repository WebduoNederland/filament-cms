<?php

namespace WebduoNederland\FilamentCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property array $components
 * @property PageStatusEnum $status
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
            'components' => 'array',
            'status' => PageStatusEnum::class,
        ];
    }
}
