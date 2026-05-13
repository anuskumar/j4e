<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_purchase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('event_ticket_id')->nullable();
            $table->integer('total_number')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_address1')->nullable();
            $table->string('shipping_address2')->nullable();
            $table->unsignedBigInteger('shipping_country')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_pincode')->nullable();
            $table->boolean('accepted_tearms_condetion')->default(0);
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('payment_currency')->nullable();
            $table->string('payment_card_number')->nullable();
            $table->string('payment_id')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->boolean('is_payment_completed')->default(0);
            $table->unsignedBigInteger('purchase_status')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade');
            $table->foreign('event_ticket_id')->references('id')->on('event_tickets')->onDelete('set null');
            $table->foreign('shipping_country')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('payment_currency')->references('id')->on('currency')->onDelete('set null');
            $table->foreign('purchase_status')->references('id')->on('purchase_status')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_purchase');
    }
};
