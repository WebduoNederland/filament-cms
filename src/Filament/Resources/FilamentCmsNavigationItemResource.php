<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsNavigationItem;

class FilamentCmsNavigationItemResource extends Resource
{
    protected static ?string $model = FilamentCmsNavigationItem::class;

    protected static ?string $slug = 'navigation-items';

    protected static ?string $modelLabel = 'navigation item';

    protected static ?string $pluralModelLabel = 'navigation items';

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-m-queue-list';

    protected static ?string $navigationLabel = 'Navigation items';

    protected static ?int $navigationSort = 1001;

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
                                TextInput::make(getFilamentCmsFieldName('name'))
                                    ->label('Name')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                        return $textInput->translatable();
                                    }),

                                TextInput::make(getFilamentCmsFieldName('slug'))
                                    ->label('Slug')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                        return $textInput->translatable();
                                    }),

                                Toggle::make('has_sub_items')
                                    ->live(),

                                Section::make('Sub items')
                                    ->schema([
                                        Repeater::make('sub_items')
                                            ->hiddenLabel()
                                            ->reorderableWithButtons()
                                            ->schema([
                                                TextInput::make(getFilamentCmsFieldName('name'))
                                                    ->label('Name')
                                                    ->required()
                                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                                        return $textInput->translatable();
                                                    }),

                                                TextInput::make(getFilamentCmsFieldName('slug'))
                                                    ->label('Slug')
                                                    ->required()
                                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                                        return $textInput->translatable();
                                                    }),
                                            ]),
                                    ])
                                    ->hidden(fn (Get $get): bool => ! $get('has_sub_items')),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sort')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('sub_items')
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->formatStateUsing(function (array $state) {
                        return $state['slug'][config('filament-cms.multi_language_default', 'en')];
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->reorderable('sort')
            ->defaultSort('sort');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilamentCmsNavigationItem::route('/'),
            'create' => Pages\CreateFilamentCmsNavigationItem::route('/create'),
            'edit' => Pages\EditFilamentCmsNavigationItem::route('/{record}/edit'),
        ];
    }
}
