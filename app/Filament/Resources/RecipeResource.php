<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'CATALOG';

    protected static ?string $navigationLabel = 'Resep';

    protected static ?string $modelLabel = 'Resep';

    protected static ?string $pluralModelLabel = 'Resep & BOM';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Resep')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Terkait Produk')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Resep')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('yield')
                            ->label('Porsi / Yield')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->helperText('Jumlah porsi yang dihasilkan dari resep standar ini'),

                        Forms\Components\Textarea::make('description')
                            ->label('Petunjuk Singkat Memasak')
                            ->rows(3),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Rahasia Dapur')
                            ->rows(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Daftar Bahan Baku (Ingredients)')
                    ->description('Rincian bahan yang dibutuhkan untuk membuat resep ini')
                    ->schema([
                        Forms\Components\Repeater::make('ingredients')
                            ->relationship('ingredients')
                            ->schema([
                                Forms\Components\TextInput::make('ingredient_name')
                                    ->label('Nama Bahan')
                                    ->required()
                                    ->placeholder('Contoh: Beras Ramos, Daging Ayam Fillet, Bumbu Kuning'),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required()
                                    ->default(1),

                                Forms\Components\TextInput::make('unit')
                                    ->label('Satuan')
                                    ->required()
                                    ->placeholder('gram, kg, ml, butir, sdm')
                                    ->default('gram'),

                                Forms\Components\TextInput::make('notes')
                                    ->label('Keterangan')
                                    ->placeholder('Contoh: potong dadu 2cm'),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Bahan Baku')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Resep')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk Terkait')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('yield')
                    ->label('Yield')
                    ->formatStateUsing(fn ($state) => "{$state} Porsi")
                    ->sortable(),

                Tables\Columns\TextColumn::make('ingredients_count')
                    ->label('Jumlah Bahan')
                    ->counts('ingredients')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
