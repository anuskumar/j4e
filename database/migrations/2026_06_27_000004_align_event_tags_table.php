<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('event_tags')) {
            return;
        }

        if (! Schema::hasColumn('event_tags', 'tag_image')) {
            Schema::table('event_tags', function (Blueprint $table) {
                $table->string('tag_image')->nullable()->after('tag_name');
            });
        }

        if (! Schema::hasColumn('event_tags', 'deleted_at')) {
            Schema::table('event_tags', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('event_tags')) {
            return;
        }

        if (Schema::hasColumn('event_tags', 'tag_image')) {
            Schema::table('event_tags', function (Blueprint $table) {
                $table->dropColumn('tag_image');
            });
        }

        if (Schema::hasColumn('event_tags', 'deleted_at')) {
            Schema::table('event_tags', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
