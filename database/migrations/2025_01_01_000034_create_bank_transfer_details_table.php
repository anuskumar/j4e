<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_transfer_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();

            $table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currency')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_transfer_details');
    }
};
