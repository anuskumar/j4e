<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_purchase', function (Blueprint $table) {
            $table->string('sales_id', 16)->nullable()->unique()->after('id');
        });

        DB::table('ticket_purchase')
            ->whereNull('sales_id')
            ->orderBy('id')
            ->each(function ($purchase) {
                do {
                    $salesId = Str::upper(Str::random(16));
                } while (DB::table('ticket_purchase')->where('sales_id', $salesId)->exists());

                DB::table('ticket_purchase')
                    ->where('id', $purchase->id)
                    ->update(['sales_id' => $salesId]);
            });
    }

    public function down(): void
    {
        Schema::table('ticket_purchase', function (Blueprint $table) {
            $table->dropUnique(['sales_id']);
            $table->dropColumn('sales_id');
        });
    }
};
