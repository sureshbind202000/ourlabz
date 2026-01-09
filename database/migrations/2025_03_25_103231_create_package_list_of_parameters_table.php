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
        Schema::create('package_list_of_parameters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id');
            $table->string('name');
            $table->text('content');
            $table->integer('no_of_parameter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_list_of_parameters');
    }
};
