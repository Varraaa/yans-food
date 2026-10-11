<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CateringPaymentResource\Pages;
use App\Models\CateringOrder;
use App\Models\CateringPayment;
use App\Services\PaymentService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CateringPaymentResource extends Resource
{
    protected static ?string $model = CateringPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'CATERING';

    protected static ?string $navigationLabel = 'Pembayaran Catering';

    protected static ?string $modelLabel = 'Pembayaran Catering';

    protected static ?string $pluralModelLabel = 'Riwayat Pembayaran Catering';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('catering_order_id')
                            ->label('Terkait Pesanan Catering')
                            ->relationship('order', 'order_number')
                            ->getOptionLabelFromRecordUsing(fn (CateringOrder $record) => "{$record->order_number} - {$record->customer_name} (Total: Rp " . number_format($record->total, 0, ',', '.') . ")")
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('payment_number')
                            ->label('Nomor Kwitansi / Bayar')
                            ->default(fn () => 'PAY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)))
                            ->required()
                            ->readOnly(),

                        Forms\Components\Select::make('payment_type')
                            ->label('Jenis Pembayaran')
                            ->options([
                                'DP' => 'DP (Uang Muka)',
                                'PELUNASAN' => 'Pelunasan',
                                'CASH' => 'Pembayaran Penuh',
                            ])
                            ->default('DP')
                            ->required(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Nominal Diterima (Rp)')
                            ->prefix('Rp')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Transfer / Pembayaran')
                            ->options([
                                'Transfer Bank BCA' => 'Transfer Bank BCA',
                                'Transfer Bank Mandiri' => 'Transfer Bank Mandiri',
                                'Transfer Bank BRI' => 'Transfer Bank BRI',
                                'QRIS' => 'QRIS',
                                'Tunai (Cash)' => 'Tunai (Cash)',
                            ])
                            ->default('Transfer Bank BCA')
                            ->required(),

                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Terima Pembayaran')
                            ->default(now())
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Transaksi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_number')
                    ->label('No. Bayar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tanggal Bayar')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('No. Order')
                    ->searchable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('order.customer_name')
                    ->label('Pelanggan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PELUNASAN' => 'success',
                        'DP' => 'warning',
                        default => 'info',
                    }),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge(),
            ])
            ->defaultSort('payment_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('payment_type')
                    ->options([
                        'DP' => 'DP',
                        'PELUNASAN' => 'PELUNASAN',
                        'CASH' => 'CASH',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCateringPayments::route('/'),
            'create' => Pages\CreateCateringPayment::route('/create'),
        ];
    }
}
