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
            $table->unsignedBigInteger('guest_id'); // Foreign key column
            $table->string('contact_number');
            $table->string('reference_id')->unique();
            $table->string('email')->unique();
            $table->enum('status', ['Pending', 'Occupied', 'Completed', 'Cancelled', 'Reschedule'])
            ->default('Pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');
    
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
