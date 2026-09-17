<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('event_type')) {
            return;
        }

        if (! Schema::hasColumn('event_type', 'sort_order')) {
            Schema::table('event_type', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_active');
            });
        }

        $types = DB::table('event_type')->orderBy('id')->get(['id']);
        foreach ($types as $index => $type) {
            DB::table('event_type')->where('id', $type->id)->update([
                'sort_order' => $index + 1,
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('event_type') && Schema::hasColumn('event_type', 'sort_order')) {
            Schema::table('event_type', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};
