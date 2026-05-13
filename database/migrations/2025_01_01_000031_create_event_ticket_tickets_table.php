<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_ticket_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_tickets')->nullable();
            $table->unsignedBigInteger('event_timing')->nullable();
            $table->unsignedBigInteger('event_seating')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('seat_id')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->decimal('ticket_amount', 10, 2)->nullable();
            $table->boolean('on_sale')->default(1);
            $table->boolean('is_sold')->default(0);
            $table->boolean('under_purchase_hold')->default(0);
            $table->datetime('purchase_hold_time')->nullable();
            $table->datetime('purchase_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_tickets')->references('id')->on('event_tickets')->onDelete('cascade');
            $table->foreign('event_timing')->references('id')->on('event_timings')->onDelete('set null');
            $table->foreign('event_seating')->references('id')->on('venue_seating')->onDelete('set null');
            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('purchase_id')->references('id')->on('ticket_purchase')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_ticket_tickets');
    }
};
