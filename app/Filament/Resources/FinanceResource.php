<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceResource\Pages;
use App\Models\Finance;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FinanceResource extends Resource
{
    protected static ?string $model = Finance::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Keuangan';

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Keuangan';

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Transaksi')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Jenis')
                            ->options([
                                'income' => '📥 Pemasukan',
                                'expense' => '📤 Pengeluaran',
                            ])
                            ->required(),

                        Forms\Components\Select::make('fund_source')
                            ->label('Sumber Dana')
                            ->options([
                                'kas_dkm' => 'Kas DKM',
                                'gias' => 'GIAS',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah (Rp)')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),

                        Forms\Components\TextInput::make('description')
                            ->label('Keterangan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('transaction_date')
                            ->label('Tanggal Transaksi')
                            ->required()
                            ->default(now()),

                        Forms\Components\FileUpload::make('receipt_image')
                            ->label('Bukti Transaksi')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')
                            ->directory('finances')
                            ->visibility('public'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => $state === 'income' ? 'Pemasukan' : 'Pengeluaran')
                    ->color(fn(string $state) => $state === 'income' ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('fund_source')
                    ->label('Sumber')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => $state === 'kas_dkm' ? 'Kas DKM' : 'GIAS')
                    ->color('info'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(40)
                    ->searchable(),
            ])
            ->defaultSort('transaction_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinances::route('/'),
            'create' => Pages\CreateFinance::route('/create'),
            'edit' => Pages\EditFinance::route('/{record}/edit'),
        ];
    }
}
