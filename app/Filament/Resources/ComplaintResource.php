<?php

namespace App\Filament\Resources;

use App\Enums\ComplaintStatus;
use App\Filament\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Pengaduan';
    protected static ?string $modelLabel = 'Pengaduan';
    protected static ?string $pluralModelLabel = 'Pengaduan';
    protected static string|\UnitEnum|null $navigationGroup = 'Layanan';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Pelapor')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('ticket_code')
                            ->label('Kode Tiket')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('citizen_name')
                            ->label('Nama Pelapor')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('citizen_nik')
                            ->label('NIK')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('citizen_phone')
                            ->label('No. HP')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('citizen_email')
                            ->label('Email')
                            ->disabled()
                            ->dehydrated(false),
                    ]),

                Section::make('Detail Pengaduan')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Pengaduan')
                            ->rows(4)
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\FileUpload::make('evidence_image')
                            ->label('Bukti Foto')
                            ->disk('public')
                            ->directory('complaints')
                            ->visibility('public')
                            ->openable()
                            ->disabled()
                            ->dehydrated(false),
                    ]),

                Section::make('Proses Pengaduan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description('Ubah status dan berikan tanggapan untuk pengaduan ini.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'verified' => 'Terverifikasi',
                                'in_progress' => 'Sedang Diproses',
                                'completed' => 'Selesai',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false)
                            ->dehydrated(),

                        Forms\Components\Textarea::make('admin_response')
                            ->label('Tanggapan Admin')
                            ->rows(4)
                            ->placeholder('Tulis tanggapan atau catatan tindak lanjut...')
                            ->columnSpanFull()
                            ->dehydrated(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('Kode Tiket')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('citizen_name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Complaint $record): string => $record->citizen_phone ?? ''),


                Tables\Columns\TextColumn::make('description')
                    ->label('Isi Pengaduan')
                    ->limit(50)
                    ->tooltip(fn(Complaint $record): string => $record->description ?? ''),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(function ($state): string {
                        $value = $state instanceof ComplaintStatus ? $state->value : (string) $state;

                        return match ($value) {
                            'pending' => 'warning',
                            'verified' => 'info',
                            'in_progress' => 'primary',
                            'completed' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        };
                    })
                    ->formatStateUsing(function ($state): string {
                        $value = $state instanceof ComplaintStatus ? $state->value : (string) $state;

                        return match ($value) {
                            'pending' => 'Pending',
                            'verified' => 'Terverifikasi',
                            'in_progress' => 'Diproses',
                            'completed' => 'Selesai',
                            'rejected' => 'Ditolak',
                            default => $value,
                        };
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        ComplaintStatus::Pending->value => 'Pending',
                        ComplaintStatus::Verified->value => 'Terverifikasi',
                        ComplaintStatus::InProgress->value => 'Diproses',
                        ComplaintStatus::Completed->value => 'Selesai',
                        ComplaintStatus::Rejected->value => 'Ditolak',
                    ]),

            ])
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
            'index' => Pages\ListComplaints::route('/'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', ComplaintStatus::Pending->value)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('status', ComplaintStatus::Pending->value)->count();

        return $count > 0 ? 'warning' : 'gray';
    }
}
