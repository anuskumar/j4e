<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ticket_type')) {
            return;
        }

        if (!Schema::hasColumn('ticket_type', 'description')) {
            Schema::table('ticket_type', function (Blueprint $table) {
                $table->string('description', 255)->default('')->after('ticket_type_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ticket_type') && Schema::hasColumn('ticket_type', 'description')) {
            Schema::table('ticket_type', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
