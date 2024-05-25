<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsRedirectResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsRedirect;

class FilamentCmsRedirectResource extends Resource
{
    protected static ?string $model = FilamentCmsRedirect::class;

    protected static ?string $slug = 'redirects';

    protected static ?string $modelLabel = 'redirect';

    protected static ?string $pluralModelLabel = 'redirects';

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-m-arrow-uturn-right';

    protected static ?string $navigationLabel = 'Redirects';

    protected static ?int $navigationSort = 1002;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-m-home')
                            ->schema([
                                TextInput::make('from_slug')
                                    ->rules(['required', 'max:255'])
                                    ->required(),

                                TextInput::make('to')
                                    ->rules(['required', 'max:255'])
                                    ->helperText('This can either be a new page slug, or an external site like: https://google.com')
                                    ->required(),

                                Select::make('type')
                                    ->options([
                                        '301' => '301 (Permanent redirect)',
                                        '302' => '302 (Temporary redirect)',
                                    ])
                                    ->native(false)
                                    ->default(301)
                                    ->rules(['required'])
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from_slug')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('to')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('hits')
                    ->sortable(),

                TextColumn::make('last_hit')
                    ->sortable()
                    ->date(config()->string('filament-cms.time_format')),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilamentCmsRedirect::route('/'),
            'create' => Pages\CreateFilamentCmsRedirect::route('/create'),
            'edit' => Pages\EditFilamentCmsRedirect::route('/{record}/edit'),
        ];
    }
}
