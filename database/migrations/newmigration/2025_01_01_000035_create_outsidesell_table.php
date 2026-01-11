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
        Schema::create('outsidesell', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_ticket_tickets_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('date')->nullable();
            $table->string('payment_mode')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('event_ticket_tickets_id')->references('id')->on('event_ticket_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outsidesell');
    }
};
