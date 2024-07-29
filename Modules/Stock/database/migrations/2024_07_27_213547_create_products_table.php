<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Basic product information
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            // Pricing
            $table->decimal('price', 10, 2);

            // Stock information
            $table->integer('quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);

            // Relationships
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('SET NULL');

            // Other attributes
            $table->json('attributes')->nullable(); // For custom attributes like color, size, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
