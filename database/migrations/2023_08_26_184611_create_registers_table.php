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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();

            // warehouse_status_id
            $table->foreignId('warehouse_status_id')->constrained(
                table: 'warehouse_states',
                column: 'id',
                indexName: 'register_warehouse_status'
            )->onUpdate('cascade')->onDelete('cascade');

            // product_id
             $table->foreignId('product_id')->constrained(
                table: 'products',
                column: 'id',
                indexName: 'product_register'
            )->onUpdate('cascade')->onDelete('cascade');

            $table->integer('deposit')->default(0);
            $table->integer('liquor_shop')->default(0);
            $table->integer('ordered')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
