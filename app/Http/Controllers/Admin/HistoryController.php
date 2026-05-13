<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    /**
     * Display a listing of notification history (payment logs).
     */
    public function index(Request $request): View
    {
        $query = PaymentLog::with('pensioner');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('pensioner', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        return view('admin.history.index', compact('logs'));
    }
}
