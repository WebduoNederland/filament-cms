<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
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
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsPageResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

class FilamentCmsPageResource extends Resource
{
    protected static ?string $model = FilamentCmsPage::class;

    protected static ?string $slug = 'pages';

    protected static ?string $modelLabel = 'page';

    protected static ?string $pluralModelLabel = 'pages';

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-m-document-text';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?int $navigationSort = 1000;

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

                                TextInput::make(getFilamentCmsFieldName('slug'))
                                    ->label('Slug')
                                    ->rules(['required', 'max:255'])
                                    ->helperText('If this needs to be the home/landing page simply enter a: /')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                        return $textInput->translatable();
                                    }),

                                Select::make('status')
                                    ->options(PageStatusEnum::class)
                                    ->native(false)
                                    ->default(PageStatusEnum::Published)
                                    ->rules(['required'])
                                    ->required(),
                            ]),

                        Tab::make('Content')
                            ->icon('heroicon-m-rectangle-group')
                            ->schema([
                                Builder::make('components')
                                    ->addActionLabel(__('filament-cms::filament.pages.add_component_btn'))
                                    ->reorderable()
                                    ->reorderableWithButtons()
                                    ->cloneable()
                                    ->blockNumbers(false)
                                    ->collapsed()
                                    ->blocks(function (): array {
                                        /** @var array $components */
                                        $components = config('filament-cms.components', []);

                                        return collect($components)
                                            ->map(function (array $block): Block {
                                                return $block['filament_block']::make();
                                            })
                                            ->values()
                                            ->toArray();
                                    }),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-m-document-magnifying-glass')
                            ->schema([
                                TextInput::make(getFilamentCmsFieldName('meta_title'))
                                    ->label('Meta title')
                                    ->rules(['required', 'max:255'])
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                        return $textInput->translatable();
                                    }),

                                Textarea::make(getFilamentCmsFieldName('meta_description'))
                                    ->label('Meta description')
                                    ->rows(4)
                                    ->live(true)
                                    ->helperText(function (?string $state): Htmlable {
                                        $count = strlen($state ?? '');

                                        $color = $count > 160 ? 'rgb(var(--warning-500))' : 'inherit';

                                        return new HtmlString('<span style="color: '.$color.';">'.$count.' / 160 characters</span>');
                                    })
                                    ->when(filamentCmsMultiLangEnabled(), function (Textarea $textarea): Tabs {
                                        return $textarea->translatable();
                                    }),

                                Select::make('meta_robots')
                                    ->options([
                                        'index, follow' => 'index, follow',
                                        'index, nofollow' => 'index, nofollow',
                                        'noindex, nofollow' => 'noindex, nofollow',
                                    ])
                                    ->default('index, follow')
                                    ->native(false),

                                // TODO: File upload for og_image
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

                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (PageStatusEnum $state): string => match ($state) {
                        PageStatusEnum::Published => 'success',
                        PageStatusEnum::Unpublished => 'warning',
                    })
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilamentCmsPage::route('/'),
            'create' => Pages\CreateFilamentCmsPage::route('/create'),
            'edit' => Pages\EditFilamentCmsPage::route('/{record}/edit'),
        ];
    }
}
