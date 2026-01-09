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
        Schema::create('product_varients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->string('product_identification_no')->nullable();
            $table->decimal('regular_price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->nullable();
            $table->enum('discount_type', ['flat', 'percent'])->nullable();
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->decimal('bulk_regular_price', 10, 2)->default(0);
            $table->decimal('bulk_discount', 10, 2)->nullable();
            $table->enum('bulk_discount_type', ['flat', 'percent'])->nullable();
            $table->decimal('bulk_selling_price', 10, 2)->nullable();
            $table->integer('bulk_moq')->default(1);
            $table->string('release_date')->nullable();
            $table->string('warranty')->nullable();
            $table->string('stock')->nullable();
            $table->enum('in_stock', ['1', '0'])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_varients');
    }
};
