<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Berita / Artikel';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Konten Berita')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $state, callable $set) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique('categories', 'slug'),
                            ]),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Gambar Utama')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->disk('public')
                            ->directory('posts')
                            ->visibility('public')
                            ->openable(),

                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Berita')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->default(now()),

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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Gambar')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=N&background=10b981&color=fff'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
