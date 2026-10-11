<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'SYSTEM';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Manajemen Pengguna';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun Staf & Hak Akses')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Peran (Role)')
                            ->options([
                                'admin' => 'Admin (Akses Penuh)',
                                'cashier' => 'Kasir (Operasional POS)',
                            ])
                            ->default('cashier')
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Administrator',
                        'cashier' => 'Kasir',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'cashier' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
