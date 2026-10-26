<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope('dummy_isolation', function ($builder) {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->email === 'dummy@yansfood.id') {
                    $builder->where('expenses.created_by', $user->id);
                } else {
                    $dummyUser = \App\Models\User::where('email', 'dummy@yansfood.id')->first(['id']);
                    if ($dummyUser) {
                        $builder->where(function ($q) use ($dummyUser) {
                            $q->where('expenses.created_by', '!=', $dummyUser->id)
                              ->orWhereNull('expenses.created_by');
                        });
                    }
                }
            }
        });
    }

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
