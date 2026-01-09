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
        Schema::create('referred_consultations', function (Blueprint $table) {
            $table->id();
             $table->bigInteger('referred_by');
            $table->bigInteger('referred_to');
            $table->bigInteger('referred_consultation');
            $table->text('notes');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referred_consultations');
    }
};
