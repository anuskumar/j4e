<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('event_tags')) {
            return;
        }

        if (! Schema::hasColumn('event_tags', 'sort_order')) {
            Schema::table('event_tags', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_active');
            });
        }

        $tags = DB::table('event_tags')->orderBy('id')->get(['id']);
        foreach ($tags as $index => $tag) {
            DB::table('event_tags')->where('id', $tag->id)->update([
                'sort_order' => $index + 1,
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('event_tags') && Schema::hasColumn('event_tags', 'sort_order')) {
            Schema::table('event_tags', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};
