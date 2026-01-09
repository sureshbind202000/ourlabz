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
        Schema::create('corporate_details', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_id');
            $table->string('company_name');
            $table->string('company_reg_no')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('company_size')->nullable();
            $table->string('establishment_year')->nullable();
            $table->string('website_url')->nullable();
            $table->string('no_of_emp_for_test')->nullable();
            $table->text('prefer_test_type')->nullable();
            $table->string('on_site_test')->nullable()->comment('Yes/No');
            $table->string('home_sample_collection')->nullable()->comment('Yes/No');
            $table->text('prefer_lab_test_partner')->nullable();
            $table->string('frequency_of_testing')->nullable();
            $table->string('billing_contact_name')->nullable();
            $table->string('billing_contact_email')->nullable();
            $table->string('company_gst')->nullable();
            $table->string('prefer_payment_method')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->string('company_reg_cert')->nullable();
            $table->string('employee_list')->nullable();
            $table->string('authorization_letter')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_details');
    }
};
