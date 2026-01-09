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
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->string('lab_id');
            $table->string('lab_name');
            $table->string('lab_registration_no')->nullable();
            $table->string('accreditation_details')->nullable();
            $table->text('lab_type')->nullable();
            $table->string('year_of_establishment')->nullable();
            $table->string('operating_hours')->nullable();
            $table->string('primary_contact_name')->nullable();
            $table->integer('phone');
            $table->string('email')->nullable();
            $table->text('website_url')->nullable();
            $table->text('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->text('google_map_location')->nullable();
            $table->decimal('latitude', 10, 7)->nullable()->after('postal_code');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->text('list_of_test_available')->nullable();
            $table->string('sample_collection')->nullable()->comment('Yes/No');
            $table->string('home_sample_collection')->nullable()->comment('Yes/No');
            $table->string('tat_for_reports')->nullable();
            $table->decimal('standard_test_price', 10, 2)->nullable();
            $table->decimal('corporate_test_price', 10, 2)->nullable();
            $table->string('insurance_partner_accepted')->nullable()->comment('Yes/No');
            $table->text('list_of_accepted_insurances')->nullable();
            $table->string('lab_license')->nullable();
            $table->string('doctor_license')->nullable();
            $table->text('signatory_doctor_details')->nullable();
            $table->string('lab_logo')->nullable();
            $table->text('lab_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
