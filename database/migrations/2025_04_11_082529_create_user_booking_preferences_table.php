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
        Schema::create('user_booking_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->text('preferred_test_type')->nullable();
            $table->text('preferred_lab_clinic')->nullable();
            $table->string('preferred_date_time')->nullable();
            $table->string('sample_collecton_mode')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_booking_preferences');
    }
};
