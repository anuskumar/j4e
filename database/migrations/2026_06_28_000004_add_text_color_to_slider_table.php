<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('slider', 'text_color')) {
            Schema::table('slider', function (Blueprint $table) {
                $table->string('text_color', 10)->default('white')->after('slide_image');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('slider', 'text_color')) {
            Schema::table('slider', function (Blueprint $table) {
                $table->dropColumn('text_color');
            });
        }
    }
};
