<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

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
                                TextInput::make('name')
                                    ->required(),

                                Select::make('type')
                                    ->options([
                                        'slug' => 'Slug',
                                        'page' => 'Page',
                                    ])
                                    ->live()
                                    ->required(),

                                TextInput::make('value')
                                    ->label('Slug')
                                    ->required()
                                    ->hidden(fn (Get $get): bool => $get('type') !== 'slug'),

                                Select::make('value')
                                    ->label('Page')
                                    ->options(FilamentCmsPage::query()->pluck('name', 'id'))
                                    ->required()
                                    ->hidden(fn (Get $get): bool => $get('type') !== 'page'),

                                Toggle::make('has_sub_items')
                                    ->live(),

                                Section::make('Sub items')
                                    ->schema([
                                        Repeater::make('sub_items')
                                            ->hiddenLabel()
                                            ->reorderableWithButtons()
                                            ->schema([
                                                TextInput::make('name')
                                                    ->required(),

                                                Select::make('sub_item_type')
                                                    ->label('Type')
                                                    ->options([
                                                        'slug' => 'Slug',
                                                        'page' => 'Page',
                                                    ])
                                                    ->live()
                                                    ->required(),

                                                TextInput::make('value')
                                                    ->label('Slug')
                                                    ->required()
                                                    ->hidden(fn (Get $get): bool => $get('sub_item_type') !== 'slug'),

                                                Select::make('value')
                                                    ->label('Page')
                                                    ->options(FilamentCmsPage::query()->pluck('name', 'id'))
                                                    ->required()
                                                    ->hidden(fn (Get $get): bool => $get('sub_item_type') !== 'page'),
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
                        return $state['name'];
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
