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
        if (! Schema::hasColumn('event', 'seller_fee_percent')) {
            Schema::table('event', function (Blueprint $table) {
                $table->decimal('seller_fee_percent', 5, 2)->default(10.00)->after('ticket_types');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('event', 'seller_fee_percent')) {
            Schema::table('event', function (Blueprint $table) {
                $table->dropColumn('seller_fee_percent');
            });
        }
    }
};
