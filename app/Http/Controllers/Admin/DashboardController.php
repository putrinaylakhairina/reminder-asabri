<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pensioner;
use App\Models\PaymentLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPensioners = Pensioner::count();
        $totalJatuhTempo = Pensioner::whereDate('tanggal_jatuh_tempo', '<=', now())->count();
        
        $mendekati = Pensioner::whereDate('tanggal_jatuh_tempo', '>', now())
                      ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(7))->count();

        $totalNotifikasi = PaymentLog::count();
        $notifikasiSukses = PaymentLog::whereIn('status', ['sent', 'email_sent'])->count();

        $recentPensioners = Pensioner::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPensioners',
            'totalJatuhTempo',
            'mendekati',
            'totalNotifikasi',
            'notifikasiSukses',
            'recentPensioners'
        ));
    }
}
