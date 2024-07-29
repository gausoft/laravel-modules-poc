<?php

namespace Modules\Stock\Contracts;

interface StockServiceInterface
{
    public function getAvailableQuantity(int $productId): int;

    /**
     * Get the availability of a list of products.
     *
     * @param array $items Array of products to check, where each product is defined by:
     *                     - 'product_id' (int) : The product's ID
     *                     - 'quantity' (int) : The requested quantity
     *
     * @return array Tableau des résultats, avec chaque produit défini par :
     *               - 'product_name' (string) : The name of the product
     *               - 'product_id' (int) : The product's ID
     *               - 'is_available' (bool) : Availability status of the product
     */
    public function getProductsAvailabilities(array $items): array;

    public function getAvailableProductQuantityByLocation(int $productId, int $locationId): array;

    public function saveStockOut(int $productId, int $locationId, int $quantity): void;

    public function getStockMovementsByProduct(int $productId): array;

    public function getStockMovementsByLocation(int $locationId): array;

    public function hasSufficientStock(int $productId, int $quantity): bool;

    public function decreaseStock(int $productId, int $quantity): void;
}
