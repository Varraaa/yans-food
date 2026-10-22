<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'CASH';
    case QRIS = 'QRIS';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Tunai (Cash)',
            self::QRIS => 'QRIS',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::QRIS => 'QRIS',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::CASH => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::QRIS => 'bg-sky-50 text-sky-700 border-sky-200',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::CASH => 'payments',
            self::QRIS => 'qr_code_2',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
