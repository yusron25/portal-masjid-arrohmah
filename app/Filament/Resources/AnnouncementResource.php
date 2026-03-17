<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Pengumuman & Agenda';

    protected static ?string $modelLabel = 'Pengumuman';

    protected static ?string $pluralModelLabel = 'Pengumuman & Agenda';

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->label('Jenis')
                            ->options([
                                'pengumuman' => '📢 Pengumuman',
                                'agenda' => '📅 Agenda Kegiatan',
                            ])
                            ->required(),

                        Forms\Components\DateTimePicker::make('event_date')
                            ->label('Tanggal Acara')
                            ->helperText('Wajib diisi untuk agenda kegiatan'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('URL Video')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Tempel link YouTube, Facebook Video, dll.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Isi Pengumuman')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi')
                            ->required()
                            ->resizableImages()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('announcements')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsAcceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'image/webp',
                            ])
                            ->helperText('Gunakan tombol sisipkan gambar untuk menambahkan gambar ke dalam isi pengumuman atau agenda.')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3',
                                'bulletList', 'orderedList',
                                'blockquote', 'codeBlock',
                                'link', 'attachFiles', 'redo', 'undo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_pinned')
                            ->label('Sematkan di Atas')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->default(now()),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => $state === 'pengumuman' ? 'Pengumuman' : 'Agenda')
                    ->color(fn(string $state) => $state === 'pengumuman' ? 'warning' : 'info'),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('Pinned')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Terbit')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
