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
            $table->string('country')->nullable()->after('address');
            $table->string('country_code')->nullable()->after('country');
            $table->string('profile')->nullable()->after('country_code');
            $table->date('date_or_birth')->nullable()->after('profile');
            $table->boolean('is_active')->default(1)->after('date_or_birth');
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
            $table->dropColumn(['user_type', 'phone', 'address', 'country', 'country_code', 'profile', 'date_or_birth', 'is_active', 'last_login']);
            $table->dropSoftDeletes();
        });
    }
};
