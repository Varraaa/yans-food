<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CateringOrderResource\Pages;
use App\Models\CateringOrder;
use App\Models\Product;
use App\Services\CateringService;
use App\Services\PaymentService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CateringOrderResource extends Resource
{
    protected static ?string $model = CateringOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'CATERING';

    protected static ?string $navigationLabel = 'Pesanan Catering';

    protected static ?string $modelLabel = 'Pesanan Catering';

    protected static ?string $pluralModelLabel = 'Pesanan Catering';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pelanggan & Acara')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Nomor Pesanan')
                            ->default(fn () => 'CAT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)))
                            ->required()
                            ->readOnly(),

                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pemesan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->required()
                            ->placeholder('081234567890'),

                        Forms\Components\Textarea::make('customer_address')
                            ->label('Alamat Acara / Pengantaran')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('event_date')
                            ->label('Tanggal Acara')
                            ->required(),

                        Forms\Components\TimePicker::make('event_time')
                            ->label('Waktu Acara')
                            ->required(),

                        Forms\Components\TextInput::make('event_purpose')
                            ->label('Keperluan Acara')
                            ->placeholder('Syukuran, Pernikahan, Rapat Kantor, Khitanan, dll.')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Menu / Permintaan Khusus')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Daftar Menu & Paket Catering')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Pilih Menu')
                                    ->options(Product::where('status', 'available')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $product = Product::find($state);
                                        if ($product) {
                                            $set('product_name', $product->name);
                                            $set('unit_price', $product->price);
                                            $qty = (int) ($get('quantity') ?: 1);
                                            $set('subtotal', $product->price * $qty);
                                        }
                                    }),

                                Forms\Components\Hidden::make('product_name')
                                    ->required(),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Jumlah (Porsi/Box)')
                                    ->numeric()
                                    ->default(10)
                                    ->minValue(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $price = (float) ($get('unit_price') ?: 0);
                                        $set('subtotal', $price * (int) $state);
                                    }),

                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required()
                                    ->readOnly(),

                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required()
                                    ->readOnly(),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Menu Catering')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status & Penagihan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Pengerjaan (Progres)')
                            ->options([
                                'PENDING' => 'PENDING (Menunggu Konfirmasi)',
                                'CONFIRMED' => 'CONFIRMED (Pesanan Disetujui)',
                                'IN_PROGRESS' => 'IN_PROGRESS (Sedang Dimasak)',
                                'READY' => 'READY (Siap Saji/Kemas)',
                                'DELIVERING' => 'DELIVERING (Sedang Diantar ke Lokasi)',
                                'COMPLETED' => 'COMPLETED (Selesai)',
                                'CANCELLED' => 'CANCELLED (Dibatalkan)',
                            ])
                            ->default('PENDING')
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'UNPAID' => 'UNPAID (Belum Bayar)',
                                'DP' => 'DP (Uang Muka Diterima)',
                                'PAID' => 'PAID (Lunas)',
                            ])
                            ->default('UNPAID')
                            ->disabled()
                            ->helperText('Status pembayaran dihitung otomatis dari riwayat pencatatan pembayaran DP & Pelunasan.'),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal (Rp)')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->readOnly(),

                        Forms\Components\TextInput::make('discount')
                            ->label('Diskon Khusus (Rp)')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('total')
                            ->label('Total Pesanan (Rp)')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->readOnly(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Order')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Pemesan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total Order')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status Progres')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'CONFIRMED' => 'info',
                        'IN_PROGRESS' => 'indigo',
                        'READY' => 'purple',
                        'DELIVERING' => 'amber',
                        'COMPLETED' => 'success',
                        'CANCELLED' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PAID' => 'success',
                        'DP' => 'warning',
                        'UNPAID' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('event_date', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'PENDING' => 'PENDING',
                        'CONFIRMED' => 'CONFIRMED',
                        'IN_PROGRESS' => 'IN_PROGRESS',
                        'READY' => 'READY',
                        'DELIVERING' => 'DELIVERING',
                        'COMPLETED' => 'COMPLETED',
                        'CANCELLED' => 'CANCELLED',
                    ]),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'UNPAID' => 'UNPAID',
                        'DP' => 'DP',
                        'PAID' => 'PAID',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (CateringOrder $record) => app(CateringService::class)->generateWhatsAppUrl($record), shouldOpenInNewTab: true),

                Tables\Actions\Action::make('pay')
                    ->label('Catat Bayar')
                    ->icon('heroicon-o-banknotes')
                    ->color('primary')
                    ->visible(fn (CateringOrder $record) => $record->payment_status !== 'PAID')
                    ->form([
                        Forms\Components\Select::make('payment_type')
                            ->label('Jenis Pembayaran')
                            ->options([
                                'DP' => 'DP (Uang Muka)',
                                'PELUNASAN' => 'Pelunasan',
                                'CASH' => 'Pembayaran Penuh Langsung',
                            ])
                            ->default('DP')
                            ->required(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Nominal Pembayaran (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->helperText(function (CateringOrder $record) {
                                $remaining = app(PaymentService::class)->getRemainingBalance($record);
                                return 'Sisa tagihan saat ini: Rp ' . number_format($remaining, 0, ',', '.');
                            }),

                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Transfer / Bayar')
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
                            ->label('Tanggal Pembayaran')
                            ->default(now())
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Bukti / Keterangan'),
                    ])
                    ->action(function (CateringOrder $record, array $data, PaymentService $paymentService) {
                        try {
                            $paymentService->recordPayment(
                                orderId: $record->id,
                                paymentType: $data['payment_type'],
                                amount: (float) $data['amount'],
                                paymentMethod: $data['payment_method'],
                                receivedBy: auth()->id() ?? 1,
                                paymentDate: $data['payment_date'],
                                notes: $data['notes'] ?? null
                            );

                            Notification::make()
                                ->title('Pembayaran berhasil dicatat!')
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Gagal mencatat pembayaran')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCateringOrders::route('/'),
            'create' => Pages\CreateCateringOrder::route('/create'),
            'edit' => Pages\EditCateringOrder::route('/{record}/edit'),
        ];
    }
}
