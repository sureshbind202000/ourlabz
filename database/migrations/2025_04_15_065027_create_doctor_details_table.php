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
        Schema::create('doctor_details', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id');
            $table->string('medical_license_number')->nullable();
            $table->string('license_issue_authority')->nullable();
            $table->text('specialization')->nullable();
            $table->string('year_of_experience')->nullable();
            $table->string('affiliated_hospital_clinic_name')->nullable();
            $table->text('hospital_clinic_address')->nullable();
            $table->string('consultation_type')->nullable();
            $table->text('preferred_test_category')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('tin')->nullable();
            $table->string('medical_degree_certificate')->nullable();
            $table->string('medical_license')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('id_type')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_details');
    }
};
