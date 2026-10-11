<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'ingredient_name',
        'quantity',
        'unit',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
        ];
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
