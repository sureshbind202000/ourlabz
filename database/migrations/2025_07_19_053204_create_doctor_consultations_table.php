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
        Schema::create('doctor_consultations', function (Blueprint $table) {
            $table->id();
              $table->bigInteger('user_id');
            $table->bigInteger('doctor_id');
            $table->bigInteger('address_id');
            $table->string('consultation_type');
            $table->text('prescription')->nullable();
            $table->string('prescription_upload')->nullable();
            $table->string('appointment_date');
            $table->string('appointment_time');
            $table->string('meeting_url')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');
            $table->bigInteger('payment_id')->default(0);
            $table->bigInteger('referred_to')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_consultations');
    }
};
