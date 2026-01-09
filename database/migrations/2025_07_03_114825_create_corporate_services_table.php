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
        Schema::create('corporate_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('heading');
            $table->string('banner');

            $table->string('image');
            $table->string('name');
            $table->text('content')->nullable();

            $table->string('image2');
            $table->string('name2');
            $table->text('content2')->nullable();

            $table->string('image3');
            $table->string('name3');
            $table->text('content3')->nullable();

            $table->string('image4');
            $table->string('name4');
            $table->text('content4')->nullable();

            $table->string('image5');
            $table->string('name5');
            $table->text('content5')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_services');
    }
};
