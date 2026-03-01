<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaResource\Pages;
use App\Models\SocialMedia;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SocialMediaResource extends Resource
{
    protected static ?string $model = SocialMedia::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationLabel = 'Media Sosial';

    protected static ?string $modelLabel = 'Media Sosial';

    protected static ?string $pluralModelLabel = 'Media Sosial';

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Media Sosial')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'instagram' => 'Instagram',
                                'youtube' => 'YouTube',
                                'facebook' => 'Facebook',
                                'tiktok' => 'TikTok',
                                'twitter' => 'Twitter / X',
                                'whatsapp' => 'WhatsApp',
                                'telegram' => 'Telegram',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('url')
                            ->label('URL / Link')
                            ->url()
                            ->required()
                            ->maxLength(255),

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
                Tables\Columns\TextColumn::make('platform')
                    ->label('Platform')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(50)
                    ->url(fn($record) => $record->url, true),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialMedia::route('/'),
            'create' => Pages\CreateSocialMedia::route('/create'),
            'edit' => Pages\EditSocialMedia::route('/{record}/edit'),
        ];
    }
}
