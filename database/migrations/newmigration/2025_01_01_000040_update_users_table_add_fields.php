<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->nullable()->after('email');
            $table->string('phone')->nullable()->after('user_type');
            $table->text('address')->nullable()->after('phone');
            $table->boolean('is_active')->default(1)->after('address');
            $table->datetime('last_login')->nullable()->after('is_active');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'phone', 'address', 'is_active', 'last_login']);
            $table->dropSoftDeletes();
        });
    }
};
