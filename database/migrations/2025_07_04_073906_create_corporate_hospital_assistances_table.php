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
        Schema::create('corporate_hospital_assistances', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title');
            $table->string('heading');
            $table->text('content');
            $table->string('heading2');
            $table->text('content2');
            $table->string('card_image1');
            $table->string('card_image2');
            $table->string('card_image3');
            $table->string('card_title1');
            $table->string('card_title2');
            $table->string('card_title3');
            $table->text('card_content1');
            $table->text('card_content2');
            $table->text('card_content3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_hospital_assistances');
    }
};
