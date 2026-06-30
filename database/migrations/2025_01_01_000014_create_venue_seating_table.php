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
        Schema::create('venue_seating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue')->nullable();
            $table->string('seating_type_name')->nullable();
            $table->text('seating_type_desc')->nullable();
            $table->integer('number_of_seats')->nullable();
            $table->string('seat_serial_prefix')->nullable();
            $table->integer('seat_serial_start')->nullable();
            $table->integer('seat_serial_end')->nullable();
            $table->string('seating_image')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('venue')->references('id')->on('venue')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_seating');
    }
};
