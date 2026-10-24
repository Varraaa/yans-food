<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with(['product.category', 'ingredients'])->orderBy('name');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('product', function ($pq) use ($search) {
                        $pq->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('ingredients', function ($iq) use ($search) {
                        $iq->where('ingredient_name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        $totalRecipesCount = Recipe::count();
        $recipes = $query->paginate(50)->withQueryString();
        $products = Product::orderBy('name')->get(['id', 'name', 'category_id']);
        $categories = ProductCategory::orderBy('name')->get(['id', 'name']);

        return view('admin.recipes.index', compact('recipes', 'products', 'categories', 'totalRecipesCount'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.recipes.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'yield' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['required_with:ingredients', 'string', 'max:255'],
            'ingredients.*.quantity' => ['required_with:ingredients', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required_with:ingredients', 'string', 'max:50'],
            'ingredients.*.notes' => ['nullable', 'string'],
        ]);

        // ==========================================
        // DATABASE TRANSACTION: COMMIT & ROLLBACK (Closure Pattern)
        // Laravel DB::transaction otomatis melakukan BEGIN TRANSACTION,
        // COMMIT jika pembuatan resep & bahan sukses, dan ROLLBACK jika ada error.
        // ==========================================
        DB::transaction(function () use ($validated) {
            $recipe = Recipe::create([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'yield' => $validated['yield'] ?? null,
                'description' => $validated['description'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            if (!empty($validated['ingredients'])) {
                foreach ($validated['ingredients'] as $ing) {
                    if (!empty($ing['name'])) {
                        RecipeIngredient::create([
                            'recipe_id' => $recipe->id,
                            'ingredient_name' => $ing['name'],
                            'quantity' => (float)$ing['quantity'],
                            'unit' => $ing['unit'],
                            'notes' => $ing['notes'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Resep menu masakan berhasil disimpan!');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['product', 'ingredients']);
        return view('admin.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load(['product', 'ingredients']);
        $products = Product::orderBy('name')->get();

        return view('admin.recipes.edit', compact('recipe', 'products'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'yield' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['required_with:ingredients', 'string', 'max:255'],
            'ingredients.*.quantity' => ['required_with:ingredients', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required_with:ingredients', 'string', 'max:50'],
            'ingredients.*.notes' => ['nullable', 'string'],
        ]);

        // ==========================================
        // DATABASE TRANSACTION: COMMIT & ROLLBACK (Closure Pattern)
        // Menjamin proses update info resep dan replace bahan baku
        // ter-COMMIT bersamaan atau di-ROLLBACK penuh jika ada kegagalan.
        // ==========================================
        DB::transaction(function () use ($recipe, $validated) {
            $recipe->update([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'yield' => $validated['yield'] ?? null,
                'description' => $validated['description'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            $recipe->ingredients()->delete();

            if (!empty($validated['ingredients'])) {
                foreach ($validated['ingredients'] as $ing) {
                    if (!empty($ing['name'])) {
                        RecipeIngredient::create([
                            'recipe_id' => $recipe->id,
                            'ingredient_name' => $ing['name'],
                            'quantity' => (float)$ing['quantity'],
                            'unit' => $ing['unit'],
                            'notes' => $ing['notes'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Resep berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->ingredients()->delete();
        $recipe->delete();

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Resep berhasil dihapus!');
    }
}
