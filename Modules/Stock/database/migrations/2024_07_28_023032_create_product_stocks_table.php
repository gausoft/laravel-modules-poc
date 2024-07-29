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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->integer('quantity');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('SET NULL');
            $table->enum('movement_type', ['in', 'out']); // 'in' pour entrée, 'out' pour sortie
            $table->string('reason')->nullable(); // Raison du mouvement, par exemple: "achat", "vente", "retour"
            $table->foreignId('location_id')->references('id')->on('stock_locations')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
