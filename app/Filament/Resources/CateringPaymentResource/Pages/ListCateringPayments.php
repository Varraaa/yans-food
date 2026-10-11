<?php

namespace App\Filament\Resources\CateringPaymentResource\Pages;

use App\Filament\Resources\CateringPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCateringPayments extends ListRecords
{
    protected static string $resource = CateringPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Catat Pembayaran Baru'),
        ];
    }
}
