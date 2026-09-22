<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('ticket_status')
            ->where('id', 2)
            ->update(['status_name' => 'Paused']);
    }

    public function down(): void
    {
        DB::table('ticket_status')
            ->where('id', 2)
            ->update(['status_name' => 'Posted']);
    }
};
