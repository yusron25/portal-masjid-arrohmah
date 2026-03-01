<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationLabel = 'Slider';

    protected static ?string $modelLabel = 'Slider';

    protected static ?string $pluralModelLabel = 'Slider';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Slider')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar Slider')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->disk('public')
                            ->directory('sliders')
                            ->visibility('public')
                            ->openable()
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3),

                        Forms\Components\TextInput::make('link_url')
                            ->label('Link URL')
                            ->url()
                            ->maxLength(255),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Gambar')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}