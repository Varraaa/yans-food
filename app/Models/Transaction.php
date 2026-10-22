<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'transaction_time',
        'cashier_id',
        'subtotal',
        'discount',
        'total',
        'payment_method',
        'amount_paid',
        'change',
        'paid_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'paid_at' => 'datetime',
            'payment_method' => \App\Enums\PaymentMethod::class,
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'amount_paid' => 'decimal:2',
            'change' => 'decimal:2',
        ];
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePaidWith($query, $method)
    {
        $value = $method instanceof \App\Enums\PaymentMethod ? $method->value : $method;
        return $query->where('payment_method', $value);
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        if ($from && $to) {
            return $query->whereBetween('transaction_date', [$from, $to]);
        } elseif ($from) {
            return $query->where('transaction_date', '>=', $from);
        } elseif ($to) {
            return $query->where('transaction_date', '<=', $to);
        }

        return $query;
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}

