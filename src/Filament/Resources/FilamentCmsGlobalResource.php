<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsGlobalResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsGlobal;

class FilamentCmsGlobalResource extends Resource
{
    protected static ?string $model = FilamentCmsGlobal::class;

    protected static ?string $slug = 'globals';

    protected static ?string $modelLabel = 'global';

    protected static ?string $pluralModelLabel = 'globals';

    protected static string|UnitEnum|null $navigationGroup = 'General';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-m-star';

    protected static ?string $navigationLabel = 'Globals';

    protected static ?int $navigationSort = 1003;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-m-home')
                            ->schema([
                                TextInput::make('name')
                                    ->rules(['required', 'max:255'])
                                    ->required(),

                                Section::make('Data')
                                    ->schema([
                                        Builder::make('data')
                                            ->hiddenLabel()
                                            ->addActionLabel(__('filament-cms::filament.globals.add_data_btn'))
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->cloneable()
                                            ->blockNumbers(false)
                                            ->collapsed()
                                            ->blocks([
                                                // Text
                                                Block::make('text')
                                                    ->label('Text')
                                                    ->icon('heroicon-m-bars-3-center-left')
                                                    ->schema([
                                                        Textarea::make(getFilamentCmsFieldName('value'))
                                                            ->label('Value')
                                                            ->rows(4)
                                                            ->required()
                                                            ->when(filamentCmsMultiLangEnabled(), fn (Textarea $field): Textarea => $field->translatable()),
                                                    ]),

                                                Block::make('footer-links')
                                                    ->label('Footer links')
                                                    ->icon('heroicon-m-link')
                                                    ->schema([
                                                        TextInput::make('title')
                                                            ->required()
                                                            ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

                                                        Repeater::make('links')
                                                            ->schema([
                                                                TextInput::make('label')
                                                                    ->required()
                                                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

                                                                TextInput::make('link')
                                                                    ->required()
                                                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),
                                                            ]),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilamentCmsGlobal::route('/'),
            'create' => Pages\CreateFilamentCmsGlobal::route('/create'),
            'edit' => Pages\EditFilamentCmsGlobal::route('/{record}/edit'),
        ];
    }
}
