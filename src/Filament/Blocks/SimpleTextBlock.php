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
                TextInput::make(getFilamentCmsFieldName('title'))
                    ->label('Title')
                    ->required()
                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

                Textarea::make(getFilamentCmsFieldName('text'))
                    ->label('Text')
                    ->rows(5)
                    ->required()
                    ->when(filamentCmsMultiLangEnabled(), fn (Textarea $field): Textarea => $field->translatable()),
            ]);
    }
}
