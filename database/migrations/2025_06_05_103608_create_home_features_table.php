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
        Schema::create('home_features', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->string('content');
            $table->string('icon2');
            $table->string('title2');
            $table->string('content2');
            $table->string('icon3');
            $table->string('title3');
            $table->string('content3');
            $table->string('icon4');
            $table->string('title4');
            $table->string('content4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_features');
    }
};
