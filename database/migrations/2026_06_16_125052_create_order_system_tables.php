<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //  Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('payment_slip')->nullable();
            $table->timestamps();
        });

        //  Order Items Table 
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade'); // ကော်မရှင်ပေးရန် Vendor ID
            $table->integer('quantity');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->decimal('price', 12, 2); // ဝယ်စဉ်က ပစ္စည်းစျေးနှုန်း
            $table->decimal('admin_commission', 12, 2)->default(0.00);
            $table->decimal('vendor_amount', 12, 2)->default(0.00);
            $table->timestamps();
        });

        //  Users Table တွင် balance ထည့်ရန်
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'balance')) {
                $table->decimal('balance', 12, 2)->default(0.00)->after('vendor_status');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};
