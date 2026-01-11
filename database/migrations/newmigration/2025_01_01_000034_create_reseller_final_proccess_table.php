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
        Schema::create('reseller_final_proccess', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('commission_amount', 10, 2)->nullable();
            $table->boolean('is_processed')->default(0);
            $table->datetime('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('ticket_purchase')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_final_proccess');
    }
};
