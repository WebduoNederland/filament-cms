<?php

namespace WebduoNederland\FilamentCms\Enums;

use Filament\Support\Contracts\HasLabel;

enum PageStatusEnum: string implements HasLabel
{
    case Published = 'published';
    case Unpublished = 'unpublished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Published => __('filament-cms::enums.page_status.published'),
            self::Unpublished => __('filament-cms::enums.page_status.unpublished'),
        };
    }
}
