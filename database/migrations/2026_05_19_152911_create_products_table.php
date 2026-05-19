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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // ဥပမာ - 99.99
            $table->string('image')->nullable(); // ပစ္စည်းပုံလမ်းကြောင်းသိမ်းရန်
            $table->integer('stock')->default(0); // ပစ္စည်းလက်ကျန်
        
            // ဘယ် Vendor တင်လိုက်တာလဲဆိုတာ သိဖို့ (Foreign Key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
