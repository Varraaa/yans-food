<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'catering_order_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function cateringOrder()
    {
        return $this->belongsTo(CateringOrder::class, 'catering_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
