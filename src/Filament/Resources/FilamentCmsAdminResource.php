<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsAdminResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsAdmin;

class FilamentCmsAdminResource extends Resource
{
    protected static ?string $model = FilamentCmsAdmin::class;

    protected static ?string $slug = 'admins';

    protected static ?string $modelLabel = 'admin';

    protected static ?string $pluralModelLabel = 'admins';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationIcon = 'heroicon-m-users';

    protected static ?string $navigationLabel = 'Admins';

    protected static ?int $navigationSort = 10000;

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
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),

                                        TextInput::make('email')
                                            ->email()
                                            ->unique(ignoreRecord: true)
                                            ->required(),
                                    ]),

                                TextInput::make('password')
                                    ->helperText(fn (string $operation): string => $operation === 'edit' ? 'Leave this field empty if you do not want to update the password' : '')
                                    ->password()
                                    ->revealable()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create'),
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

                TextColumn::make('email')
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
            'index' => Pages\ListFilamentCmsAdmin::route('/'),
            'create' => Pages\CreateFilamentCmsAdmin::route('/create'),
            'edit' => Pages\EditFilamentCmsAdmin::route('/{record}/edit'),
        ];
    }
}
