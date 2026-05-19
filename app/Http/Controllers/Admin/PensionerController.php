<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pensioner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class PensionerController extends Controller
{
    public function index(Request $request)
    {
        $query = Pensioner::query();

        if ($request->has('status')) {
            $status = $request->status;
            if ($status === 'jatuh_tempo') {
                $query->whereDate('tanggal_jatuh_tempo', '<=', now());
            } elseif ($status === 'mendekati') {
                $query->whereDate('tanggal_jatuh_tempo', '>', now())
                      ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(7));
            } elseif ($status === 'aman') {
                $query->whereDate('tanggal_jatuh_tempo', '>', now()->addDays(7));
            }
        }

        $pensioners = $query->latest()->paginate(10);

        return view('admin.pensioners.index', compact('pensioners'));
    }

    public function create()
    {
        return view('admin.pensioners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|unique:pensioners,nip',
            'instansi' => 'required|string|max:255',
            'gaji_pensiun' => 'required|numeric',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->nip), // Default password is NIP
            'role' => 'asabri',
        ]);

        Pensioner::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'instansi' => $request->instansi,
            'gaji_pensiun' => $request->gaji_pensiun,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.pensioners.index')->with('success', 'Data pensiunan berhasil ditambahkan.');
    }

    public function edit(Pensioner $pensioner)
    {
        return view('admin.pensioners.edit', compact('pensioner'));
    }

    public function update(Request $request, Pensioner $pensioner)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pensioner->user_id,
            'nip' => 'required|string|unique:pensioners,nip,' . $pensioner->id,
            'instansi' => 'required|string|max:255',
            'gaji_pensiun' => 'required|numeric',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $pensioner->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        $pensioner->update($request->all());

        return redirect()->route('admin.pensioners.index')->with('success', 'Data pensiunan berhasil diperbarui.');
    }

    public function destroy(Pensioner $pensioner)
    {
        $pensioner->user->delete();
        $pensioner->delete();

        return redirect()->route('admin.pensioners.index')->with('success', 'Data pensiunan berhasil dihapus.');
    }

    public function exportPdf()
    {
        $pensioners = Pensioner::all();
        $pdf = Pdf::loadView('admin.pensioners.pdf', compact('pensioners'));
        return $pdf->download('data-pensiunan.pdf');
    }
}
