<?php

namespace WebduoNederland\FilamentCms\Filament\Resources;

use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use UnitEnum;
use WebduoNederland\FilamentCms\Filament\Resources\FilamentCmsBlogResource\Pages;
use WebduoNederland\FilamentCms\Models\FilamentCmsBlog;

class FilamentCmsBlogResource extends Resource
{
    protected static ?string $model = FilamentCmsBlog::class;

    protected static ?string $slug = 'blogs';

    protected static ?string $modelLabel = 'blog';

    protected static ?string $pluralModelLabel = 'blogs';

    protected static string|UnitEnum|null $navigationGroup = 'General';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-m-newspaper';

    protected static ?string $navigationLabel = 'Blogs';

    protected static ?int $navigationSort = 1001;

    public static function form(Schema $schema): Schema
    {
        /** @var string $blogDisk */
        $blogDisk = config('filament-cms.blog_assets_disk');

        /** @var string $blogPath */
        $blogPath = config('filament-cms.blog_assets_path');

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
                                    ->rules(['required', 'max:255'])
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

                                TextInput::make(getFilamentCmsFieldName('slug'))
                                    ->label('Slug')
                                    ->rules(['required', 'max:255'])
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),

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
                                            ->when(filamentCmsMultiLangEnabled(), fn (TextInput $field): TextInput => $field->translatable()),
                                    ]),
                            ]),

                        Tab::make('Content')
                            ->icon('heroicon-m-bars-3-center-left')
                            ->schema([
                                RichEditor::make(getFilamentCmsFieldName('content'))
                                    ->label('Content')
                                    ->required()
                                    ->when(filamentCmsMultiLangEnabled(), fn (RichEditor $field): RichEditor => $field->translatable()),
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
