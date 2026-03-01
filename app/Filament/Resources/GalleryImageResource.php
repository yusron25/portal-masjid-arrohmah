<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationLabel = 'Foto Galeri';

    protected static ?string $modelLabel = 'Foto';

    protected static ?string $pluralModelLabel = 'Foto Galeri';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('gallery_id')
                    ->label('Galeri')
                    ->relationship('gallery', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
                    ->label('Foto')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->disk('public')
                    ->directory('gallery-images')
                    ->visibility('public')
                    ->openable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gallery.title')
                    ->label('Galeri')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}