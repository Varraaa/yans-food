<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_number',
        'expense_date',
        'expense_type',
        'category_id',
        'name',
        'amount',
        'payment_method',
        'period_start',
        'period_end',
        'description',
        'receipt_image',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'period_start' => 'date',
            'period_end' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
