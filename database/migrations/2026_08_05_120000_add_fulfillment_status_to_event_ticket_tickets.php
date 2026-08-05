<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_ticket_tickets', function (Blueprint $table) {
            $table->string('fulfillment_status', 20)->nullable()->after('is_sold');
        });

        // Backfill: sold + file => sold, sold + no file => pending
        DB::table('event_ticket_tickets')
            ->where('is_sold', 1)
            ->whereNotNull('file')
            ->where('file', '!=', '')
            ->update(['fulfillment_status' => 'sold']);

        DB::table('event_ticket_tickets')
            ->where('is_sold', 1)
            ->where(function ($query) {
                $query->whereNull('file')->orWhere('file', '');
            })
            ->update(['fulfillment_status' => 'pending']);
    }

    public function down(): void
    {
        Schema::table('event_ticket_tickets', function (Blueprint $table) {
            $table->dropColumn('fulfillment_status');
        });
    }
};
