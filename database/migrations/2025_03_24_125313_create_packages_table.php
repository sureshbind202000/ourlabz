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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('test_id')->unique(); // Randomly generated Test ID
            $table->string('name');
            $table->text('about_test')->nullable();
            $table->text('list_of_parameters_note')->nullable();
            $table->text('test_preparation')->nullable();
            $table->text('why_this_test')->nullable();
            $table->text('interpretations')->nullable();
            $table->text('department_category');
            $table->text('measures')->nullable(); // Components measured
            $table->text('identifies')->nullable();
            $table->text('sample_type_specimen'); // Full sample details
            $table->string('tat')->comment('Turnaround Time');
            $table->string('recommendation_of_age')->nullable();
            $table->string('stability_room')->nullable();
            $table->string('stability_refrigerated')->nullable();
            $table->string('stability_frozen')->nullable(); // Added missing column
            $table->text('method')->nullable();
             $table->boolean('is_draft')->default(0)->comment('0 = Published, 1 = Draft');
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
