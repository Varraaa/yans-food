<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Services\ReceiptService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationGroup = 'TRANSACTION';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Riwayat Transaksi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Forms\Components\TextInput::make('transaction_number')
                            ->label('Nomor Transaksi')
                            ->disabled(),

                        Forms\Components\DatePicker::make('transaction_date')
                            ->label('Tanggal')
                            ->disabled(),

                        Forms\Components\TimePicker::make('transaction_time')
                            ->label('Waktu')
                            ->disabled(),

                        Forms\Components\Select::make('cashier_id')
                            ->label('Kasir')
                            ->relationship('cashier', 'name')
                            ->disabled(),

                        Forms\Components\TextInput::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->disabled(),

                        Forms\Components\TextInput::make('status')
                            ->label('Status')
                            ->disabled(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Rincian Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('discount')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('total')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('amount_paid')
                            ->label('Nominal Diterima')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('change')
                            ->label('Kembalian')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Item Transaksi (Snapshot Historis)')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->label('Nama Produk')
                                    ->disabled(),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Qty')
                                    ->disabled(),

                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->prefix('Rp')
                                    ->disabled(),

                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->prefix('Rp')
                                    ->disabled(),
                            ])
                            ->columns(4)
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->disableItemMovement()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_number')
                    ->label('No. Transaksi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('transaction_time')
                    ->label('Waktu')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('cashier.name')
                    ->label('Kasir')
                    ->searchable()
                    ->default('-')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total Transaksi')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->modalHeading('Preview Struk Kasir')
                    ->modalContent(fn (Transaction $record) => view('filament.components.receipt-preview', [
                        'receipt' => app(ReceiptService::class)->generateCustomerReceipt($record),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }
}
