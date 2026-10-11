<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'catering_order_id',
        'payment_number',
        'payment_type',
        'amount',
        'payment_method',
        'payment_date',
        'received_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function cateringOrder()
    {
        return $this->belongsTo(CateringOrder::class, 'catering_order_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
