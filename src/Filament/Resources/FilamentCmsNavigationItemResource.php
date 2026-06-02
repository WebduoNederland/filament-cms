<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsNavigationItemResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsNavigationItem;

class FilamentCmsNavigationItemResource extends Resource
{
    protected static ?string $model = FilamentCmsNavigationItem::class;

    protected static ?string $slug = 'navigation-items';

    protected static ?string $modelLabel = 'navigation item';

    protected static ?string $pluralModelLabel = 'navigation items';

    protected static string|UnitEnum|null $navigationGroup = 'General';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-m-queue-list';

    protected static ?string $navigationLabel = 'Navigation items';

    protected static ?int $navigationSort = 1002;

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
                                TextInput::make(getFilamentCmsFieldName('name'))
                                    ->label('Name')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

                                TextInput::make(getFilamentCmsFieldName('slug'))
                                    ->label('Slug')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

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
                                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

                                                TextInput::make(getFilamentCmsFieldName('slug'))
                                                    ->label('Slug')
                                                    ->required()
                                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),
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
                        /** @var string $defaultLanguage */
                        $defaultLanguage = config('filament-cms.multi_language_default', 'en');

                        return $state['slug'][$defaultLanguage];
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
