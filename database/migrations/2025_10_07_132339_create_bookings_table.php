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
                $table->foreignId('guest_id')->constrained()->onDelete('cascade');
                $table->foreignId('room_id')->constrained()->onDelete('cascade');
                $table->string('reference_id')->unique();
                $table->dateTime('check_in');
                $table->dateTime('check_out');
                $table->integer('num_of_guests');
                $table->integer('total_price');
                $table->enum('payment_status', ['Unpaid', 'Paid', 'Refunded'])->default('Unpaid');
                $table->enum('status', [
                    'Pending', 'Confirmed', 'Checked-In', 'Completed', 'Cancelled', 'Rescheduled'
                ])->default('Pending');
                $table->text('remarks')->nullable();
                $table->timestamps();
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
