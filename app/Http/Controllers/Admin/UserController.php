<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $jenjang = $request->input('jenjang');

        $baseQuery = Peserta::query();

        if ($jenjang) {
            $baseQuery->where('jenjang', $jenjang);
        }

        $statsQuery = clone $baseQuery;

        $totalPeserta = $statsQuery->count();
        $verifiedCount = (clone $statsQuery)->where('is_verified', true)->count();
        $unverifiedCount = $totalPeserta - $verifiedCount;

        $pesertas = $baseQuery->with('user')
            ->orderByRaw('nomor_urut IS NULL, nomor_urut ASC')
            ->latest()
            ->paginate(10)
            ->onEachSide(1)
            ->appends(['jenjang' => $jenjang]);
            
        return view('admin.users.index', compact('pesertas', 'totalPeserta', 'verifiedCount', 'unverifiedCount'));
    }

    /**
     * Verify a participant's data.
     */
    public function verify(Peserta $peserta): RedirectResponse
    {
        $peserta->update(['is_verified' => true]);

        return redirect()->route('admin.users.index')->with('status', 'Data peserta berhasil diverifikasi.');
    }

    /**
     * Download participant data as a PDF.
     */
    public function downloadPDF(Peserta $peserta)
    {
        $pdf = Pdf::loadView('admin.users.pdf', ['peserta' => $peserta]);
        return $pdf->download('data-peserta-'.$peserta->nama_peserta.'.pdf');
    }
}
