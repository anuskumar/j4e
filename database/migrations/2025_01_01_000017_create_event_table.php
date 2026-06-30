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
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('event_name')->nullable();
            $table->unsignedBigInteger('event_type')->nullable();
            $table->unsignedBigInteger('venue')->nullable();
            $table->unsignedBigInteger('event_tag')->nullable();
            $table->unsignedBigInteger('event_added_by')->nullable();
            $table->date('event_from_date')->nullable();
            $table->date('event_to_date')->nullable();
            $table->text('event_desc')->nullable();
            $table->string('event_image')->nullable();
            $table->json('artists')->nullable();
            $table->json('ticket_types')->nullable();
            $table->decimal('seller_fee_percent', 5, 2)->nullable();
            $table->decimal('customer_fee_percent', 5, 2)->nullable();
            $table->boolean('event_is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('event_type')->references('id')->on('event_type')->onDelete('set null');
            $table->foreign('venue')->references('id')->on('venue')->onDelete('set null');
            $table->foreign('event_tag')->references('id')->on('event_tags')->onDelete('set null');
            $table->foreign('event_added_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
