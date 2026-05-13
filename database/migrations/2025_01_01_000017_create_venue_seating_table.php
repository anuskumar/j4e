<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venue_seating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->string('seating_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('number_of_seats')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('venue_id')->references('id')->on('venue')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_seating');
    }
};
