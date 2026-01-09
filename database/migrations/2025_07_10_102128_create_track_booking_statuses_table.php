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
        Schema::create('track_booking_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->unsignedBigInteger('booking_patient_id');
            $table->unsignedTinyInteger('status');
            $table->string('title');
            $table->timestamps();

            $table->foreign('booking_patient_id')->references('id')->on('booking_patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_booking_statuses');
    }
};
