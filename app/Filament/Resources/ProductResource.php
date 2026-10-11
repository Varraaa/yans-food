<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'CATALOG';

    protected static ?string $navigationLabel = 'Produk';

    protected static ?string $modelLabel = 'Produk';

    protected static ?string $pluralModelLabel = 'Produk';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->description('Kelola detail produk, harga, stok, dan kategori')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Kategori Baru')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\TextInput::make('price')
                            ->label('Harga Jual (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('stock')
                            ->label('Stok')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Forms\Components\TextInput::make('unit')
                            ->label('Satuan')
                            ->placeholder('Contoh: porsi, box, pcs, gelas')
                            ->default('porsi')
                            ->required()
                            ->maxLength(50),

                        Forms\Components\Select::make('status')
                            ->label('Status Ketersediaan')
                            ->options([
                                'available' => 'Sedia',
                                'unavailable' => 'Tidak Tersedia',
                            ])
                            ->default('available')
                            ->required()
                            ->helperText('Produk "Tidak Tersedia" tidak dapat dijual di sistem POS kasir.'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Produk')
                            ->image()
                            ->directory('products')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Produk')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('/images/logo.png'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->formatStateUsing(fn ($record) => "{$record->stock} {$record->unit}")
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Sedia',
                        'unavailable' => 'Tidak Tersedia',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Sedia',
                        'unavailable' => 'Tidak Tersedia',
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
