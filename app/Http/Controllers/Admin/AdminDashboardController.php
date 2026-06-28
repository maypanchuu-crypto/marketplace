<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStores = User::where('role', 'vendor')->count();

        $activeUsers = User::where('role', 'customer')
            ->where('last_login_at', '>=', Carbon::now()->subDays(30))
            ->count();

        // 📊 Database ထဲက အချက်အလက်များကို နှစ်နှင့်လအလိုက် ဆွဲထုတ်ခြင်း
        $registrationsRaw = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->whereRaw('YEAR(created_at) >= ?', [2024])
            ->groupBy('year', 'month')
            ->get();

        // 💡 Alpine.js ဖတ်ရလွယ်အောင် ဒေတာပုံစံကို Object (Key-Value) အဖြစ် စနစ်တကျ ပြောင်းလဲခြင်း
        $registrationsData = [];

        // ၂၀၂၄ မှ ယခုနှစ်အထိ နှစ်စဉ် ၁၂ လစာ Default 0 ပေးထားမည်
        $currentYear = date('Y');
        for ($y = 2024; $y <= $currentYear; $y++) {
            $registrationsData[$y] = array_fill(0, 12, 0); // JavaScript Array အတွက် Index 0 မှ 11 အထိ
        }

        // Database ထဲကထွက်လာတဲ့ ဒေတာတွေကို သက်ဆိုင်ရာ နှစ်နှင့်လအလိုက် ထည့်သွင်းခြင်း
        foreach ($registrationsRaw as $data) {
            if (isset($registrationsData[$data->year])) {
                // SQL Month က 1 မှ 12 မို့လို့ JavaScript Array Index (0-11) ဖြစ်ရန် 1 နှုတ်ပေးရပါမည်
                $registrationsData[$data->year][$data->month - 1] = $data->count;
            }
        }

        // View ဆီသို့ ပို့ပေးခြင်း
        return view('admin.dashboard', compact('totalStores', 'activeUsers', 'registrationsData'));
    }
}
