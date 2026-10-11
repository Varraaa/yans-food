<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'event_date',
        'event_time',
        'event_purpose',
        'notes',
        'subtotal',
        'discount',
        'total',
        'status',
        'payment_status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(CateringOrderItem::class, 'catering_order_id');
    }

    public function payments()
    {
        return $this->hasMany(CateringPayment::class, 'catering_order_id');
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getRemainingBalanceAttribute(): float
    {
        return max(0.0, (float) $this->total - $this->total_paid);
    }
}
