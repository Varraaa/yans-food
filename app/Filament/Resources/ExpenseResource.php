<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-down';

    protected static ?string $navigationGroup = 'FINANCE';

    protected static ?string $navigationLabel = 'Pengeluaran';

    protected static ?string $modelLabel = 'Pengeluaran';

    protected static ?string $pluralModelLabel = 'Catatan Pengeluaran';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengeluaran Operasional')
                    ->schema([
                        Forms\Components\TextInput::make('expense_number')
                            ->label('Nomor Bukti Pengeluaran')
                            ->default(fn () => 'EXP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)))
                            ->required()
                            ->readOnly(),

                        Forms\Components\DatePicker::make('expense_date')
                            ->label('Tanggal Pengeluaran')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('category_id')
                            ->label('Kategori Pengeluaran')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Kategori Pengeluaran')
                                    ->required(),
                            ]),

                        Forms\Components\Select::make('expense_type')
                            ->label('Tipe Pengeluaran')
                            ->options([
                                'ONE_TIME' => 'Sekali Beli (One Time)',
                                'RECURRING' => 'Rutin Bulanan (Listrik, Gas, Air, dll.)',
                            ])
                            ->default('ONE_TIME')
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Pengeluaran / Barang')
                            ->required()
                            ->placeholder('Contoh: Beli Beras 25kg, Token Listrik, Plastik Mika Box')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('amount')
                            ->label('Nominal Biaya (Rp)')
                            ->prefix('Rp')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'Tunai (Kasir/Petty Cash)' => 'Tunai (Kasir/Petty Cash)',
                                'Transfer Bank BCA' => 'Transfer Bank BCA',
                                'Transfer Bank Mandiri' => 'Transfer Bank Mandiri',
                                'QRIS' => 'QRIS',
                            ])
                            ->default('Tunai (Kasir/Petty Cash)')
                            ->required(),

                        Forms\Components\DatePicker::make('period_start')
                            ->label('Mulai Periode (Opsional)')
                            ->helperText('Diisi jika pengeluaran sewa/berlangganan'),

                        Forms\Components\DatePicker::make('period_end')
                            ->label('Akhir Periode (Opsional)'),

                        Forms\Components\FileUpload::make('receipt_image')
                            ->label('Foto Bukti / Struk / Nota Fisik')
                            ->image()
                            ->directory('expenses')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan Tambahan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('expense_number')
                    ->label('No. Bukti')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('expense_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengeluaran')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->badge(),

                Tables\Columns\ImageColumn::make('receipt_image')
                    ->label('Bukti')
                    ->circular(),
            ])
            ->defaultSort('expense_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('expense_type')
                    ->label('Tipe')
                    ->options([
                        'ONE_TIME' => 'One Time',
                        'RECURRING' => 'Recurring',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
