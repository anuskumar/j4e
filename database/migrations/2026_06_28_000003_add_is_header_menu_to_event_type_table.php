<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('event_type')) {
            return;
        }

        if (!Schema::hasColumn('event_type', 'is_header_menu')) {
            Schema::table('event_type', function (Blueprint $table) {
                $table->boolean('is_header_menu')->default(false)->after('is_active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('event_type') && Schema::hasColumn('event_type', 'is_header_menu')) {
            Schema::table('event_type', function (Blueprint $table) {
                $table->dropColumn('is_header_menu');
            });
        }
    }
};
