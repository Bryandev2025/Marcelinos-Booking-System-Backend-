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
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('num_of_guests');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['Pending', 'Confirmed', 'Checked_In', 'Completed', 'Cancelled'])->default('Pending');
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Refunded'])->default('Unpaid');
            $table->text('remarks')->nullable();
            $table->timestamp('pending_expires_at')->nullable();
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
