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
    Schema::create('client_reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
        $table->date('review_date');
        $table->text('review_text');
        $table->unsignedTinyInteger('stars')->comment('Rating from 1 to 5');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_reviews');
    }
};
