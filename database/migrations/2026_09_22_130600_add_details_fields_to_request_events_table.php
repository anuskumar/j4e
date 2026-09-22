<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('request_events', function (Blueprint $table) {
            if (! Schema::hasColumn('request_events', 'website_url')) {
                $table->string('website_url')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('request_events', 'location_details')) {
                $table->text('location_details')->nullable()->after('website_url');
            }
            if (! Schema::hasColumn('request_events', 'venue_details')) {
                $table->string('venue_details')->nullable()->after('location_details');
            }
            if (! Schema::hasColumn('request_events', 'event_date')) {
                $table->date('event_date')->nullable()->after('venue_details');
            }
            if (! Schema::hasColumn('request_events', 'city')) {
                $table->string('city')->nullable()->after('event_date');
            }
            if (! Schema::hasColumn('request_events', 'artist_names')) {
                $table->json('artist_names')->nullable()->after('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('request_events', function (Blueprint $table) {
            foreach (['website_url', 'location_details', 'venue_details', 'event_date', 'city', 'artist_names'] as $column) {
                if (Schema::hasColumn('request_events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
