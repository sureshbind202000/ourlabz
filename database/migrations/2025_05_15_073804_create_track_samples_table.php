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
        Schema::create('track_samples', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id');
            $table->string('user_id');
            $table->string('patient_id');
            $table->string('order_id');
            $table->string('test_id');
            $table->string('agent_id');
            $table->text('note');
            $table->string('sample_image')->default('N/A');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_samples');
    }
};
