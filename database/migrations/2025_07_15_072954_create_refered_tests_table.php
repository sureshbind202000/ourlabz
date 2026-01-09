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
        Schema::create('refered_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refered_by_id');
            $table->unsignedBigInteger('refered_lab_id');
            $table->unsignedBigInteger('refered_test_id');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refered_tests');
    }
};
