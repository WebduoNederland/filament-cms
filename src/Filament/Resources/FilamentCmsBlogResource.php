<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsBlogResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsBlog;

class FilamentCmsBlogResource extends Resource
{
    protected static ?string $model = FilamentCmsBlog::class;

    protected static ?string $slug = 'blogs';

    protected static ?string $modelLabel = 'blog';

    protected static ?string $pluralModelLabel = 'blogs';

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-m-newspaper';

    protected static ?string $navigationLabel = 'Blogs';

    protected static ?int $navigationSort = 1001;

    public static function form(Form $form): Form
    {
        /** @var string $blogDisk */
        $blogDisk = config('filament-cms.blog_assets_disk');

        /** @var string $blogPath */
        $blogPath = config('filament-cms.blog_assets_path');

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
                                    ->rules(['required', 'max:255'])
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                        return $textInput->translatable();
                                    }),

                                TextInput::make(getFilamentCmsFieldName('slug'))
                                    ->label('Slug')
                                    ->rules(['required', ':max255'])
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                        return $textInput->translatable();
                                    }),

                                DateTimePicker::make('publish_date')
                                    ->label('Publish date')
                                    ->native(false)
                                    ->placeholder('Date...')
                                    ->default(now()->roundHour())
                                    ->required(),

                                Toggle::make('published')
                                    ->label('Published'),

                                Repeater::make('images')
                                    ->label('Images')
                                    ->minItems(1)
                                    ->defaultItems(1)
                                    ->addActionLabel('Add image')
                                    ->reorderableWithButtons()
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Image')
                                            ->image()
                                            ->optimize('webp')
                                            ->removeUploadedFileButtonPosition('bottom right')
                                            ->disk($blogDisk)
                                            ->directory($blogPath)
                                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                                $fileName = str($file->getClientOriginalName());

                                                return (string) $fileName->beforeLast('.')->slug()->append($fileName->after($fileName->beforeLast('.')))->prepend(now()->timestamp.'_');
                                            })
                                            ->required(),

                                        TextInput::make(getFilamentCmsFieldName('alt'))
                                            ->label('Alt text (image description)')
                                            ->rules(['max:255'])
                                            ->when(filamentCmsMultiLangEnabled(), function (TextInput $textInput): Tabs {
                                                return $textInput->translatable();
                                            }),
                                    ]),
                            ]),

                        Tab::make('Content')
                            ->icon('heroicon-m-bars-3-center-left')
                            ->schema([
                                RichEditor::make(getFilamentCmsFieldName('content'))
                                    ->label('Content')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), function (RichEditor $richEditor): Tabs {
                                        return $richEditor->translatable();
                                    }),
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

                IconColumn::make('published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('publish_date')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('publish_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilamentCmsBlog::route('/'),
            'create' => Pages\CreateFilamentCmsBlog::route('/create'),
            'edit' => Pages\EditFilamentCmsBlog::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        /** @var bool $enabled */
        $enabled = config('filament-cms.blogs_enabled', false);

        return $enabled;
    }
}
