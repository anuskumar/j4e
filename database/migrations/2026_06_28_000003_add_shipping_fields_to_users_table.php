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
            $table->string('shipping_name')->nullable()->after('address');
            $table->text('shipping_address2')->nullable()->after('shipping_name');
            $table->unsignedBigInteger('shipping_country')->nullable()->after('shipping_address2');
            $table->string('shipping_city')->nullable()->after('shipping_country');
            $table->string('shipping_pincode')->nullable()->after('shipping_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_address2',
                'shipping_country',
                'shipping_city',
                'shipping_pincode',
            ]);
        });
    }
};
