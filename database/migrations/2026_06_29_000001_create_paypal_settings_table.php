<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paypal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->nullable();
            $table->text('client_secret')->nullable();
            $table->string('mode')->default('sandbox');
            $table->boolean('is_enabled')->default(false);
            $table->string('webhook_id')->nullable();
            $table->string('merchant_email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paypal_settings');
    }
};
