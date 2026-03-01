<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $modelLabel = 'Galeri';

    protected static ?string $pluralModelLabel = 'Galeri';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Galeri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Galeri')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Gambar Cover')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->disk('public')
                            ->directory('galleries')
                            ->visibility('public')
                            ->openable(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->default(now()),
                    ]),

                Section::make('Foto-Foto Galeri')
                    ->icon('heroicon-o-camera')
                    ->description('Upload satu atau lebih foto untuk galeri ini.')
                    ->schema([
                        Forms\Components\Repeater::make('images')
                            ->relationship()
                            ->label('')
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('Foto')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->disk('public')
                                    ->directory('gallery-images')
                                    ->visibility('public')
                                    ->openable()
                                    ->required(),

                                Forms\Components\TextInput::make('caption')
                                    ->label('Keterangan (opsional)')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('+ Tambah Foto')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['caption'] ?? 'Foto'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('images_count')
                    ->label('Jumlah Foto')
                    ->counts('images')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Terbit')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}