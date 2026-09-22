<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event', function (Blueprint $table) {
            if (! Schema::hasColumn('event', 'venue_map')) {
                $table->string('venue_map')->nullable()->after('event_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('event', function (Blueprint $table) {
            if (Schema::hasColumn('event', 'venue_map')) {
                $table->dropColumn('venue_map');
            }
        });
    }
};
