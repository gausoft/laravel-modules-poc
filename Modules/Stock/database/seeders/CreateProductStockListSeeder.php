<?php

namespace Modules\Stock\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Stock\Models\Product;
use Modules\Stock\Models\ProductStock;
use Modules\Stock\Models\StockLocation;

class CreateProductStockListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'stock_location_name' => 'Warehouse A',
                'stock_location_description' => 'Main warehouse for electronics',
                'entries' => [
                    [
                        'product_id' => Product::inRandomOrder()->first()->id,
                        'quantity' => 50,
                    ],
                    [
                        'product_id' => Product::inRandomOrder()->first()->id,
                        'quantity' => 100,
                    ],
                    [
                        'product_id' => Product::inRandomOrder()->first()->id,
                        'quantity' => 70,
                    ],
                ],
            ],
            [
                'stock_location_name' => 'Warehouse B',
                'stock_location_description' => 'Secondary warehouse for electronics',
                'entries' => [
                    [
                        'product_id' => Product::inRandomOrder()->first()->id,
                        'quantity' => 30,
                    ],
                    [
                        'product_id' => Product::inRandomOrder()->first()->id,
                        'quantity' => 80,
                    ],
                    [
                        'product_id' => Product::inRandomOrder()->first()->id,
                        'quantity' => 60,
                    ],
                ],
            ],
        ];

        foreach ($products as $product) {
            $stockLocation = StockLocation::firstOrCreate(
                ['name' => $product['stock_location_name']],
                ['description' => $product['stock_location_description']]
            );

            foreach ($product['entries'] as $entry) {
                ProductStock::create([
                    'location_id' => $stockLocation->id,
                    'product_id' => $entry['product_id'],
                    'movement_type' => 'in',
                    'reason' => 'procurement',
                    'quantity' => $entry['quantity'],
                ]);
            }
        }
    }
}
