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
        Schema::create('qr_transactions', function (Blueprint $table) {
            $table->id();

    $table->string('tx_id')->unique();

    $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');

    $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');

    $table->decimal('amount', 12, 2);

    $table->decimal('commission_amount', 12, 2);
    $table->decimal('vendor_amount', 12, 2);

    $table->enum('status', [
        'pending',
        'generated',
        'scanned',
        'processing',
        'completed',
        'failed',
        'expired'
    ])->default('pending');

    $table->timestamp('expires_at')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_transactions');
    }
};
