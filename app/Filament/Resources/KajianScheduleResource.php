<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KajianScheduleResource\Pages;
use App\Models\KajianSchedule;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class KajianScheduleResource extends Resource
{
    protected static ?string $model = KajianSchedule::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Jadwal Kajian';

    protected static ?string $modelLabel = 'Kajian';

    protected static ?string $pluralModelLabel = 'Jadwal Kajian';

    protected static string|\UnitEnum|null $navigationGroup = 'Dakwah';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Kajian')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Tema Kajian')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('speaker')
                            ->label('Ustadz / Pemateri')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('day_of_week')
                            ->label('Hari')
                            ->options([
                                'Ahad' => 'Ahad',
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                                'Sabtu' => 'Sabtu',
                            ]),

                        Forms\Components\TimePicker::make('time_start')
                            ->label('Jam Mulai')
                            ->required(),

                        Forms\Components\TimePicker::make('time_end')
                            ->label('Jam Selesai'),

                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi / Ruangan')
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_recurring')
                            ->label('Kajian Rutin')
                            ->default(true),

                        Forms\Components\DatePicker::make('event_date')
                            ->label('Tanggal (untuk kajian non-rutin)'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tema')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('speaker')
                    ->label('Ustadz')
                    ->searchable(),

                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('Hari')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('time_start')
                    ->label('Waktu')
                    ->time('H:i'),

                Tables\Columns\IconColumn::make('is_recurring')
                    ->label('Rutin')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('day_of_week')
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
            'index' => Pages\ListKajianSchedules::route('/'),
            'create' => Pages\CreateKajianSchedule::route('/create'),
            'edit' => Pages\EditKajianSchedule::route('/{record}/edit'),
        ];
    }
}
