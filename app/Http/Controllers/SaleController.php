<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    // Display all sales
    public function index()
    {
        $sales = Sale::with([
            'customer',
            'user',
            'sales_items.product'
        ])->get();

        return SaleResource::collection($sales);
    }

    // Store a new sale
    public function store(StoreSaleRequest $request)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {

            $totalPrice = 0;
            $itemsData = [];

            // Group duplicate products and calculate total quantities
            $quantities = collect($data['items'])
                ->groupBy('product_id')
                ->map(function ($items) {
                    return $items->sum('quantity');
                });

            foreach ($quantities as $productId => $quantity) {

                $product = Product::whereKey($productId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->stock < $quantity) {
                    abort(422, "موجودی محصول {$product->name} کافی نیست");
                }
            }

            // Calculate sale items
            foreach ($data['items'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $unitPrice = $product->sale_price;
                $subtotal = $unitPrice * $item['quantity'];

                $totalPrice += $subtotal;

                $itemsData[] = [
                    "product" => $product,
                    "quantity" => $item['quantity'],
                    "unit_price" => $unitPrice,
                    "subtotal" => $subtotal,
                ];
            }

            $discount = $data['discount'] ?? 0;

            if ($discount > $totalPrice) {
                abort(422, "تخفیف نمی‌تواند بیشتر از مجموع قیمت باشد");
            }

            // Create sale
            $sale = Sale::create([
                "user_id" => auth()->id(),
                "customer_id" => $data['customer_id'],
                "total_price" => $totalPrice,
                "discount" => $discount,
                "final_price" => $totalPrice - $discount,
                "status" => "completed",
                "notes" => $data['notes'] ?? null,
            ]);

            // Create sale items and decrease stock
            foreach ($itemsData as $item) {

                $sale->sales_items()->create([
                    "product_id" => $item['product']->id,
                    "quantity" => $item['quantity'],
                    "unit_price" => $item['unit_price'],
                    "subtotal" => $item['subtotal'],
                ]);

                $item['product']->decrement(
                    'stock',
                    $item['quantity']
                );
            }

            $sale->load([
                'customer',
                'user',
                'sales_items.product'
            ]);

            return response()->json([
                "message" => "فروش موفقانه ثبت شد",
                "data" => new SaleResource($sale)
            ], 201);
        });
    }

    // Display one sale
    public function show(string $id)
    {
        $sale = Sale::with([
            'customer',
            'user',
            'sales_items.product'
        ])->findOrFail($id);

        return new SaleResource($sale);
    }

    // Update an existing sale
    public function update(UpdateSaleRequest $request, string $id)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data, $id) {

            $sale = Sale::with('sales_items.product')
                ->lockForUpdate()
                ->findOrFail($id);

            if (isset($data['items'])) {

                // Restore old product quantities
                foreach ($sale->sales_items as $oldItem) {
                    $oldItem->product()->increment(
                        'stock',
                        $oldItem->quantity
                    );
                }

                // Delete old sale items
                $sale->sales_items()->delete();

                $totalPrice = 0;
                $itemsData = [];

                // Group duplicate products
                $quantities = collect($data['items'])
                    ->groupBy('product_id')
                    ->map(function ($items) {
                        return $items->sum('quantity');
                    });

                // Check available stock
                foreach ($quantities as $productId => $quantity) {

                    $product = Product::whereKey($productId)
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($product->stock < $quantity) {
                        abort(422, "موجودی محصول {$product->name} کافی نیست");
                    }
                }

                // Calculate new sale items
                foreach ($data['items'] as $item) {

                    $product = Product::findOrFail($item['product_id']);

                    $unitPrice = $product->sale_price;
                    $subtotal = $unitPrice * $item['quantity'];

                    $totalPrice += $subtotal;

                    $itemsData[] = [
                        "product" => $product,
                        "quantity" => $item['quantity'],
                        "unit_price" => $unitPrice,
                        "subtotal" => $subtotal,
                    ];
                }

                // Create new sale items and decrease stock
                foreach ($itemsData as $item) {

                    $sale->sales_items()->create([
                        "product_id" => $item['product']->id,
                        "quantity" => $item['quantity'],
                        "unit_price" => $item['unit_price'],
                        "subtotal" => $item['subtotal'],
                    ]);

                    $item['product']->decrement(
                        'stock',
                        $item['quantity']
                    );
                }

                $sale->total_price = $totalPrice;

            } else {
                $totalPrice = $sale->total_price;
            }

            $discount = $data['discount'] ?? $sale->discount;

            if ($discount > $totalPrice) {
                abort(422, "تخفیف نمی‌تواند بیشتر از مجموع قیمت باشد");
            }

            $sale->customer_id = $data['customer_id'] ?? $sale->customer_id;
            $sale->discount = $discount;
            $sale->final_price = $totalPrice - $discount;

            if (array_key_exists('notes', $data)) {
                $sale->notes = $data['notes'];
            }

            $sale->save();

            $sale->load([
                'customer',
                'user',
                'sales_items.product'
            ]);

            return response()->json([
                "message" => "فروش موفقانه ویرایش شد",
                "data" => new SaleResource($sale)
            ], 200);
        });
    }

    // Delete a sale
    public function destroy(string $id)
    {
        return DB::transaction(function () use ($id) {

            $sale = Sale::with('sales_items.product')
                ->lockForUpdate()
                ->findOrFail($id);

            // Restore product quantities
            foreach ($sale->sales_items as $item) {
                $item->product()->increment(
                    'stock',
                    $item->quantity
                );
            }

            $sale->delete();

            return response()->json([
                "message" => "فروش موفقانه حذف شد"
            ], 200);
        });
    }
}
