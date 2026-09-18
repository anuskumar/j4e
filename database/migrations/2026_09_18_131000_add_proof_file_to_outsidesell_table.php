<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outsidesell', function (Blueprint $table) {
            if (!Schema::hasColumn('outsidesell', 'proof_file')) {
                $table->string('proof_file')->nullable()->after('remark');
            }
        });
    }

    public function down(): void
    {
        Schema::table('outsidesell', function (Blueprint $table) {
            if (Schema::hasColumn('outsidesell', 'proof_file')) {
                $table->dropColumn('proof_file');
            }
        });
    }
};
