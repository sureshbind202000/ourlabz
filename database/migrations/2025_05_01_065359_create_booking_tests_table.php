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
        Schema::create('booking_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->integer('booking_patient_id');
            $table->string('package_id');
            $table->foreign('package_id')->references('package_id')->on('packages');
            $table->decimal('price_at_booking_time', 10, 2)->default(0);
            $table->enum('report_type', ['Auto', 'Manual'])->nullable();
            $table->string('report_file')->nullable();
            $table->string('verify')->nullable();
            $table->string('certify')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_tests');
    }
};
