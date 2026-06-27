<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('event') && ! Schema::hasColumn('event', 'customer_fee_percent')) {
            Schema::table('event', function (Blueprint $table) {
                $table->decimal('customer_fee_percent', 5, 2)->nullable()->after('seller_fee_percent');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('event') && Schema::hasColumn('event', 'customer_fee_percent')) {
            Schema::table('event', function (Blueprint $table) {
                $table->dropColumn('customer_fee_percent');
            });
        }
    }
};
