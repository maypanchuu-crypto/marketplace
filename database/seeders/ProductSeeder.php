<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
        'name' => 'ကျောင်းသုံး လွယ်အိတ်',
        'description' => 'အရည်အသွေးကောင်းမွန်သော ကျောင်းသုံးလွယ်အိတ် ဖြစ်ပါသည်။',
        'price' => 15000,
        'stock' => 10,
        'user_id' => 2, // vendor ID
    ]);

    Product::create([
        'name' => 'စမတ်နာရီ (Smart Watch)',
        'description' => 'ရေစိုခံပြီး အားကစားလုပ်ရာတွင် အသုံးဝင်သော နာရီ။',
        'price' => 45000,
        'stock' => 5,
        'user_id' => 2,
    ]);
    }
}
