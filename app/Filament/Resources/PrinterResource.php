<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrinterResource\Pages;
use App\Models\Printer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrinterResource extends Resource
{
    protected static ?string $model = Printer::class;

    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static ?string $navigationGroup = 'SYSTEM';

    protected static ?string $navigationLabel = 'Printer';

    protected static ?string $modelLabel = 'Printer Thermal';

    protected static ?string $pluralModelLabel = 'Pengaturan Printer';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi Printer Kasir')
                    ->description('Atur printer thermal kasir atau dapur (Bluetooth / USB / Jaringan)')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Printer')
                            ->required()
                            ->placeholder('Contoh: Printer Kasir Depan, Printer Dapur')
                            ->maxLength(255),

                        Forms\Components\Select::make('connection_type')
                            ->label('Jenis Koneksi')
                            ->options([
                                'usb' => 'USB / Kabel',
                                'bluetooth' => 'Bluetooth Mobile',
                                'network' => 'Network / IP LAN (WiFi)',
                            ])
                            ->default('usb')
                            ->required(),

                        Forms\Components\Select::make('paper_width')
                            ->label('Lebar Kertas Thermal')
                            ->options([
                                '58mm' => '58 mm (Standard Mobile POS)',
                                '80mm' => '80 mm (Standard Kasir Desktop)',
                            ])
                            ->default('58mm')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Aktif')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Nonaktif',
                            ])
                            ->default('active')
                            ->required(),

                        Forms\Components\KeyValue::make('settings')
                            ->label('Parameter Tambahan (IP, MAC Address, Baudrate)')
                            ->keyLabel('Parameter')
                            ->valueLabel('Nilai')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Printer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('connection_type')
                    ->label('Koneksi')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('paper_width')
                    ->label('Lebar Kertas')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'danger'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrinters::route('/'),
            'create' => Pages\CreatePrinter::route('/create'),
            'edit' => Pages\EditPrinter::route('/{record}/edit'),
        ];
    }
}
