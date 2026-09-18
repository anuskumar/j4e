<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('event_tickets', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('is_admin_approved');
            }
        });
    }

    public function down(): void
    {
        Schema::table('event_tickets', function (Blueprint $table) {
            if (Schema::hasColumn('event_tickets', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });
    }
};
