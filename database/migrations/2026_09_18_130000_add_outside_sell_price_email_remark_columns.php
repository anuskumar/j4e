<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outsidesell', function (Blueprint $table) {
            if (!Schema::hasColumn('outsidesell', 'cost_price')) {
                $table->decimal('cost_price', 10, 2)->nullable()->after('payment_mode');
            }
            if (!Schema::hasColumn('outsidesell', 'sale_price')) {
                $table->decimal('sale_price', 10, 2)->nullable()->after('cost_price');
            }
            if (!Schema::hasColumn('outsidesell', 'email')) {
                $table->string('email')->nullable()->after('sale_price');
            }
            if (!Schema::hasColumn('outsidesell', 'remark')) {
                $table->text('remark')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('outsidesell', function (Blueprint $table) {
            $columns = collect(['cost_price', 'sale_price', 'email', 'remark'])
                ->filter(fn ($column) => Schema::hasColumn('outsidesell', $column))
                ->values()
                ->all();

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
