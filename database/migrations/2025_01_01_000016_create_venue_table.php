<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venue', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('location')->nullable();
            $table->unsignedBigInteger('venue_type')->nullable();
            $table->text('description')->nullable();
            $table->text('google_map_link')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('location')->references('id')->on('location')->onDelete('set null');
            $table->foreign('venue_type')->references('id')->on('venue_type')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue');
    }
};
