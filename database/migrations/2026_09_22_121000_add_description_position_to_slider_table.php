<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('slider', 'description_position')) {
            Schema::table('slider', function (Blueprint $table) {
                $table->string('description_position', 20)
                    ->default('left-center')
                    ->after('text_color');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('slider', 'description_position')) {
            Schema::table('slider', function (Blueprint $table) {
                $table->dropColumn('description_position');
            });
        }
    }
};
