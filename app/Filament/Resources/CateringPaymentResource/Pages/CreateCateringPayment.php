<?php

namespace App\Filament\Resources\CateringPaymentResource\Pages;

use App\Filament\Resources\CateringPaymentResource;
use App\Models\CateringPayment;
use App\Services\PaymentService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCateringPayment extends CreateRecord
{
    protected static string $resource = CateringPaymentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $paymentService = app(PaymentService::class);

        return $paymentService->recordPayment(
            orderId: (int) $data['catering_order_id'],
            paymentType: $data['payment_type'],
            amount: (float) $data['amount'],
            paymentMethod: $data['payment_method'],
            receivedBy: auth()->id() ?? 1,
            paymentDate: $data['payment_date'],
            notes: $data['notes'] ?? null
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
