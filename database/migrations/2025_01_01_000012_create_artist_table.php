<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field')->nullable();
            $table->string('artist_name')->nullable();
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('field')->references('id')->on('artist_field')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist');
    }
};
