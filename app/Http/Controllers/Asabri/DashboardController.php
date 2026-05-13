<?php

namespace App\Http\Controllers\Asabri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pensioner = $user->pensioner;

        if (!$pensioner) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Data pensiunan tidak ditemukan.');
        }

        // Fetch recent notification history for this pensioner
        $history = $pensioner->paymentLogs()->latest()->take(5)->get();

        return view('asabri.dashboard', compact('pensioner', 'history'));
    }
}
