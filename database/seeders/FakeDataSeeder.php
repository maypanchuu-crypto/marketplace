<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Product; // အကယ်၍ Product model ရှိလျှင် use လုပ်ပါ
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function  handle(): void
    {
        // ၁။ Super Admin အတုဆောက်ခြင်း
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin', 
            'vendor_status' => 'approved',
        ]);

        // ၂။ Vendor (ဆိုင်ရှင်) အတုဆောက်ခြင်း
        $vendor = User::create([
            'name' => 'May Store Owner',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'shop_name' => 'May\'s Store',
            'vendor_status' => 'approved',
            'balance' => 0.00, // စစချင်း လက်ကျန်ငွေ ၀ ပြထားမယ်
        ]);

        // ၃။ Customer (ဝယ်ယူသူ) အတုဆောက်ခြင်း
        $customer = User::create([
            'name' => 'Ko Ko',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        
        $product = Product::create([
            'user_id' => $vendor->id, // Vendor တင်တဲ့ product
            'name' => 'Fake Lipstick',
            'price' => 10000,
            'stock' => 50,
            // ... ကျန်တဲ့ field များ ...
        ]);

        // ၄။ Order (အော်ဒါ) အတုဆောက်ခြင်း (Pending အခြေအနေနှင့်)
        // 💡 ဤ order သည် ၁ သောင်းတန် product ဝယ်ထားခြင်းဖြစ်သည်
        Order::create([
            'user_id' => $customer->id,
            'vendor_id' => $vendor->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_amount' => 10000,
            'admin_commission' => 0.00, // pending မို့ ၀ ထားမယ်
            'vendor_amount' => 0.00,    // pending မို့ ၀ ထားမယ်
            'status' => 'pending', // 👈 စမ်းသပ်ဖို့ Pending ထားပါမယ်
            'customer_name' => 'Ko Ko',
            'customer_phone' => '0912345678',
            'shipping_address' => 'Yangon',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->command->info('Fake data (Admin, Vendor, Customer, Product, Pending Order) created successfully!');
    }
}
