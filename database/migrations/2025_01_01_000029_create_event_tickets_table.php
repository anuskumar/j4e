<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->string('ticket_name')->nullable();
            $table->unsignedBigInteger('ticket_type')->nullable();
            $table->unsignedBigInteger('mobile_application_id')->nullable();
            $table->unsignedBigInteger('event')->nullable();
            $table->unsignedBigInteger('event_timing')->nullable();
            $table->string('row')->nullable();
            $table->string('seat_from')->nullable();
            $table->string('seat_to')->nullable();
            $table->integer('no_of_tickets')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedBigInteger('venue_seating')->nullable();
            $table->decimal('ticket_amount', 10, 2)->nullable();
            $table->decimal('face_value', 10, 2)->nullable();
            $table->unsignedBigInteger('ticket_restrictions')->nullable();
            $table->text('features')->nullable();
            $table->unsignedBigInteger('amount_currency')->nullable();
            $table->unsignedBigInteger('face_value_currency')->nullable();
            $table->datetime('booking_expiry_date_time')->nullable();
            $table->text('disclaimer_note')->nullable();
            $table->text('cancellation_policy_notes')->nullable();
            $table->string('map_layout')->nullable();
            $table->boolean('is_admin_approved')->default(0);
            $table->unsignedBigInteger('ticket_status')->nullable();
            $table->unsignedBigInteger('split_type')->nullable();
            $table->decimal('web_price', 10, 2)->nullable();
            $table->decimal('seller_fee', 10, 2)->nullable();
            $table->decimal('recive_perticket', 10, 2)->nullable();
            $table->decimal('total_recive', 10, 2)->nullable();
            $table->string('proof_of_id')->nullable();
            $table->string('proof_of_purchase')->nullable();
            $table->string('ticket_upload')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_type')->references('id')->on('ticket_type')->onDelete('set null');
            $table->foreign('mobile_application_id')->references('id')->on('mobile_applications')->onDelete('set null');
            $table->foreign('event')->references('id')->on('event')->onDelete('cascade');
            $table->foreign('event_timing')->references('id')->on('event_timings')->onDelete('set null');
            $table->foreign('venue_seating')->references('id')->on('venue_seating')->onDelete('set null');
            $table->foreign('ticket_restrictions')->references('id')->on('tickets_restrictions')->onDelete('set null');
            $table->foreign('amount_currency')->references('id')->on('currency')->onDelete('set null');
            $table->foreign('face_value_currency')->references('id')->on('currency')->onDelete('set null');
            $table->foreign('ticket_status')->references('id')->on('ticket_status')->onDelete('set null');
            $table->foreign('split_type')->references('id')->on('split_types')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_tickets');
    }
};
