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
        Schema::create('reseller_tickect_sells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->decimal('sell_price', 10, 2)->nullable();
            $table->decimal('commission', 10, 2)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('event_ticket_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_tickect_sells');
    }
};
