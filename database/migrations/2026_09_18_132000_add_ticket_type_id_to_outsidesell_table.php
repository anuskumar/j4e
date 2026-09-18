<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outsidesell', function (Blueprint $table) {
            if (!Schema::hasColumn('outsidesell', 'ticket_type_id')) {
                $table->unsignedBigInteger('ticket_type_id')->nullable()->after('event_ticket_tickets_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('outsidesell', function (Blueprint $table) {
            if (Schema::hasColumn('outsidesell', 'ticket_type_id')) {
                $table->dropColumn('ticket_type_id');
            }
        });
    }
};
