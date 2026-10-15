<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->get();
        $products = Product::where('status', 'available')
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('admin.pos.index', compact('categories', 'products'));
    }

    public function checkout(Request $request, TransactionService $transactionService, ReceiptService $receiptService)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', 'in:CASH,TRANSFER,QRIS'],
        ]);

        try {
            $transaction = $transactionService->createTransaction(
                items: $validated['items'],
                amountPaid: (float) $validated['amount_paid'],
                cashierId: Auth::id() ?? 1,
                discount: (float) ($validated['discount'] ?? 0),
                paymentMethod: $validated['payment_method']
            );

            $receipt = $receiptService->generateCustomerReceipt($transaction);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi kasir berhasil disimpan!',
                'transaction' => $transaction,
                'receipt' => $receipt,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
