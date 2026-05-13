<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesertaRequest;
use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PesertaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $peserta = $request->user()->peserta;
        return view('pages.peserta.form', ['peserta' => $peserta]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePesertaRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('foto_formal')) {
            $path = $request->file('foto_formal')->store('fotos', 'public');
            $validatedData['foto_formal'] = $path;
        }

        $validatedData['user_id'] = $request->user()->id;
        $validatedData['is_verified'] = false;
        $validatedData['usia'] = Carbon::parse($validatedData['tanggal_lahir'])->age;

        Peserta::create($validatedData);

        return redirect()->route('peserta.form')->with('status', 'Data peserta berhasil dibuat! Menunggu verifikasi admin.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePesertaRequest $request, Peserta $peserta): RedirectResponse
    {
        // Ensure the user is authorized to update this participant data
        if ($request->user()->id !== $peserta->user_id) {
            abort(403);
        }
        
        $validatedData = $request->validated();

        if ($request->hasFile('foto_formal')) {
            // Delete old photo if it exists
            if ($peserta->foto_formal) {
                Storage::delete('public/' . $peserta->foto_formal);
            }
            // Store the new photo
            $path = $request->file('foto_formal')->store('fotos', 'public');
            $validatedData['foto_formal'] = $path;
        }

        $validatedData['is_verified'] = false; // Force re-verification on every update
        $validatedData['usia'] = Carbon::parse($validatedData['tanggal_lahir'])->age;

        $peserta->update($validatedData);

        return redirect()->route('peserta.form')->with('status', 'Data peserta berhasil diperbarui! Menunggu verifikasi admin.');
    }

    /**
     * Display the participant's schedule and details.
     */
    public function showJadwal(Request $request): View
    {
        $peserta = $request->user()->peserta; // Assuming a user has one Peserta record
        if (!$peserta) {
            // Handle case where peserta data doesn't exist yet,
            // perhaps redirect to the form to fill it out.
            return redirect()->route('peserta.form')->with('error', 'Silakan lengkapi data peserta Anda terlebih dahulu.');
        }

        return view('pages.peserta.jadwal', compact('peserta'));
    }
}

