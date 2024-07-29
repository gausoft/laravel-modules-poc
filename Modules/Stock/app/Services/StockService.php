<?php

namespace Modules\Stock\Services;

use Modules\Stock\Contracts\StockServiceInterface;
use Modules\Stock\Models\Product;
use Modules\Stock\Models\ProductStock;

class StockService implements StockServiceInterface
{
    public function getAvailableQuantity(int $productId): int
    {
        return ProductStock::where('product_id', $productId)
            ->selectRaw('SUM(CASE WHEN movement_type = "in" THEN quantity ELSE -quantity END) as available_quantity')
            ->value('available_quantity');
    }

    public function getProductsAvailabilities(array $items): array
    {
        $products = Product::whereIn('id', array_column($items, 'product_id'))->get();

        $availabilities = [];

        $products->map(function ($product) use ($items) {
            $availableQuantity = $this->getAvailableQuantity($product->id);

            $requestedQuantity = array_column($items, 'quantity', 'product_id')[$product->id];


            $availabilities[] = [
                'product_name' => $product->name,
                'product_id' => $product->id,
                'is_available' => $availableQuantity >= $requestedQuantity,
            ];
        });

        return $availabilities;
    }

    public function getAvailableProductQuantityByLocation(int $productId, int $locationId): array
    {
        return [];
    }

    public function saveStockOut(int $productId, int $locationId, int $quantity): void
    {
        //
    }

    public function getStockMovementsByProduct(int $productId): array
    {
        return [];
    }

    public function getStockMovementsByLocation(int $locationId): array
    {
        return [];
    }

    public function hasSufficientStock(int $productId, int $quantity): bool
    {
        $product = Product::findOrFail($productId);

        return $product->quantity >= $quantity;
    }

    public function decreaseStock(int $productId, int $quantity): void
    {
        $product = Product::findOrFail($productId);

        $product->decrement('quantity', $quantity);
    }
}
