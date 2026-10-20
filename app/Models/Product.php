<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'unit',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'product_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'product_id');
    }

    public function items()
    {
        return $this->transactionItems();
    }


    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
