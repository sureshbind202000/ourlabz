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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');

            $table->enum('booking_type', ['test', 'product']);

            $table->string('lab_id')->nullable();
            $table->string('booking_date')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('address')->nullable();

            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'Completed'])->default('Pending');
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Failed'])->default('Unpaid');

            $table->tinyInteger('sample_collection')->default(0);

            $table->text('notes')->nullable();
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->integer('shipping')->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);

            $table->string('order_id')->nullable();
            $table->tinyInteger('track_status')->default(0);
            $table->text('cancel_reason')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
