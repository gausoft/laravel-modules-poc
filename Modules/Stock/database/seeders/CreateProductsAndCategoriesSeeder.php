<?php

namespace Modules\Stock\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Stock\Models\Product;
use Modules\Stock\Models\ProductCategory;

class CreateProductsAndCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'products' => [
                    [
                        'name' => 'Laptop',
                        'sku' => 'ELEC-001',
                        'description' => 'High performance laptop',
                        'is_active' => true,
                        'price' => 1000,
                        'quantity' => 50,
                        'low_stock_threshold' => 10,
                        'attributes' => json_encode(['brand' => 'Brand A', 'color' => 'Silver'])
                    ],
                    [
                        'name' => 'Smartphone',
                        'sku' => 'ELEC-002',
                        'description' => 'Latest model smartphone',
                        'is_active' => true,
                        'price' => 600,
                        'quantity' => 100,
                        'low_stock_threshold' => 20,
                        'attributes' => json_encode(['brand' => 'Brand B', 'color' => 'Black'])
                    ],
                    [
                        'name' => 'Tablet',
                        'sku' => 'ELEC-003',
                        'description' => 'Lightweight tablet',
                        'is_active' => true,
                        'price' => 400,
                        'quantity' => 70,
                        'low_stock_threshold' => 15,
                        'attributes' => json_encode(['brand' => 'Brand C', 'color' => 'White'])
                    ],
                ],
            ],
            [
                'name' => 'Furniture',
                'products' => [
                    [
                        'name' => 'Sofa',
                        'sku' => 'FURN-001',
                        'description' => 'Comfortable leather sofa',
                        'is_active' => true,
                        'price' => 300,
                        'quantity' => 20,
                        'low_stock_threshold' => 5,
                        'attributes' => json_encode(['material' => 'Leather', 'color' => 'Brown'])
                    ],
                    [
                        'name' => 'Dining Table',
                        'sku' => 'FURN-002',
                        'description' => 'Wooden dining table',
                        'is_active' => true,
                        'price' => 200,
                        'quantity' => 15,
                        'low_stock_threshold' => 3,
                        'attributes' => json_encode(['material' => 'Wood', 'color' => 'Oak'])
                    ],
                    [
                        'name' => 'Chair',
                        'sku' => 'FURN-003',
                        'description' => 'Ergonomic office chair',
                        'is_active' => true,
                        'price' => 50,
                        'quantity' => 100,
                        'low_stock_threshold' => 10,
                        'attributes' => json_encode(['material' => 'Mesh', 'color' => 'Black'])
                    ],
                ],
            ],
            [
                'name' => 'Clothing',
                'products' => [
                    [
                        'name' => 'T-shirt',
                        'sku' => 'CLOTH-001',
                        'description' => 'Cotton t-shirt',
                        'is_active' => true,
                        'price' => 20,
                        'quantity' => 200,
                        'low_stock_threshold' => 30,
                        'attributes' => json_encode(['size' => 'L', 'color' => 'White'])
                    ],
                    [
                        'name' => 'Jeans',
                        'sku' => 'CLOTH-002',
                        'description' => 'Denim jeans',
                        'is_active' => true,
                        'price' => 40,
                        'quantity' => 150,
                        'low_stock_threshold' => 25,
                        'attributes' => json_encode(['size' => '32', 'color' => 'Blue'])
                    ],
                    [
                        'name' => 'Jacket',
                        'sku' => 'CLOTH-003',
                        'description' => 'Winter jacket',
                        'is_active' => true,
                        'price' => 60,
                        'quantity' => 80,
                        'low_stock_threshold' => 10,
                        'attributes' => json_encode(['size' => 'M', 'color' => 'Black'])
                    ],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $savedCategory = ProductCategory::firstOrCreate(['name' => $category['name']]);

            foreach ($category['products'] as $product) {
                $product['category_id'] = $savedCategory->id;

                Product::firstOrCreate(['sku' => $product['sku']], $product);
            }
        }
    }
}
