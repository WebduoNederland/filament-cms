<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsGlobalResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsGlobal;

class FilamentCmsGlobalResource extends Resource
{
    protected static ?string $model = FilamentCmsGlobal::class;

    protected static ?string $slug = 'globals';

    protected static ?string $modelLabel = 'global';

    protected static ?string $pluralModelLabel = 'globals';

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-m-star';

    protected static ?string $navigationLabel = 'Globals';

    protected static ?int $navigationSort = 1003;

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
                                                            ->when(filamentCmsMultiLangEnabled(), function (Textarea $textarea): Tabs {
                                                                return $textarea->translatable();
                                                            }),
                                                    ]),

                                                Block::make('footer-links')
                                                    ->label('Footer links')
                                                    ->icon('heroicon-m-link')
                                                    ->schema([
                                                        TextInput::make('title')
                                                            ->required()
                                                            ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                                                return $textInput->translatable();
                                                            }),

                                                        Repeater::make('links')
                                                            ->schema([
                                                                TextInput::make('label')
                                                                    ->required()
                                                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                                                        return $textInput->translatable();
                                                                    }),

                                                                TextInput::make('link')
                                                                    ->required()
                                                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                                                        return $textInput->translatable();
                                                                    }),
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
