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
            $table->string('vendor_status')->nullable(); // pending, approved, rejected
            $table->string('shop_name')->nullable();
            $table->text('shop_description')->nullable();
            $table->string('shop_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'vendor_status', 'shop_name', 'shop_description', 'shop_phone']);
        });
    }
};
