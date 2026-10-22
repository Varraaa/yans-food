<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PayCashRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'customer_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Keranjang pesanan tidak boleh kosong.',
            'items.min' => 'Pilih minimal satu menu untuk transaksi.',
            'amount_paid.required' => 'Masukkan nominal uang yang diterima dari pelanggan.',
            'amount_paid.min' => 'Nominal uang diterima tidak valid.',
        ];
    }
}
