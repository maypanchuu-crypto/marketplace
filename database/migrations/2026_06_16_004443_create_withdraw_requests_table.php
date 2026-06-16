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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ငွေထုတ်မည့် Vendor ID
            $table->decimal('amount', 12, 2);
            $table->string('payment_method'); // KPay, WaveMoney စသဖြင့်
            $table->string('account_number');
            $table->string('account_name');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_note')->nullable(); // Reject ဖြစ်ရင် အကြောင်းပြချက်ပြရန်
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};
