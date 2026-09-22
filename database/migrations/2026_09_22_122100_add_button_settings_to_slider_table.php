<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slider', function (Blueprint $table) {
            if (! Schema::hasColumn('slider', 'show_button')) {
                $table->boolean('show_button')->default(0)->after('description_position');
            }
            if (! Schema::hasColumn('slider', 'button_text')) {
                $table->string('button_text')->nullable()->default('Book Now')->after('show_button');
            }
            if (! Schema::hasColumn('slider', 'button_color')) {
                $table->string('button_color', 20)->nullable()->default('#671dcf')->after('button_text');
            }
            if (! Schema::hasColumn('slider', 'button_size')) {
                $table->string('button_size', 10)->nullable()->default('medium')->after('button_color');
            }
            if (! Schema::hasColumn('slider', 'button_position')) {
                $table->string('button_position', 20)->nullable()->default('right-bottom')->after('button_size');
            }
        });
    }

    public function down(): void
    {
        Schema::table('slider', function (Blueprint $table) {
            foreach (['show_button', 'button_text', 'button_color', 'button_size', 'button_position'] as $column) {
                if (Schema::hasColumn('slider', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
