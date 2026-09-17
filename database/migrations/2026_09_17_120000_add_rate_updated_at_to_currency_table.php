<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('currency', function (Blueprint $table) {
            if (! Schema::hasColumn('currency', 'rate_updated_at')) {
                $table->timestamp('rate_updated_at')->nullable()->after('currency_rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('currency', function (Blueprint $table) {
            if (Schema::hasColumn('currency', 'rate_updated_at')) {
                $table->dropColumn('rate_updated_at');
            }
        });
    }
};
