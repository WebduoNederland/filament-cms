<?php

namespace WebduoNederland\FilamentCms\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class SimpleTextBlock
{
    public static function make(): Block
    {
        return Block::make('simple_text')
            ->label('Simple text (example)')
            ->schema([
                TextInput::make('title')
                    ->required(),

                Textarea::make('text')
                    ->rows(5)
                    ->required(),
            ]);
    }
}
