<?php

namespace App\Filament\Resources\CateringOrderResource\Pages;

use App\Filament\Resources\CateringOrderResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCateringOrder extends EditRecord
{
    protected static string $resource = CateringOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $subtotal = 0;
        if (! empty($data['items'])) {
            foreach ($data['items'] as &$item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $item['product_name'] = $product->name;
                    $item['unit_price'] = (float) $product->price;
                    $item['subtotal'] = (float) $product->price * (int) $item['quantity'];
                    $subtotal += $item['subtotal'];
                }
            }
        }

        $data['subtotal'] = $subtotal;
        $discount = (float) ($data['discount'] ?? 0);
        $data['total'] = max(0, $subtotal - $discount);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
