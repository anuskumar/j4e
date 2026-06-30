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
        Schema::create('event_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resellerid')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_email')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('accnt_no')->nullable();
            $table->string('bic')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resellerid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_banks');
    }
};
