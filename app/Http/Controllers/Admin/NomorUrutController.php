<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NomorUrutController extends Controller
{
    /**
     * Generate unique, random sequence numbers for all verified participants.
     */
    public function generate(): RedirectResponse
    {
        // Protection: Check if any participant already has a sequence number.
        if (Peserta::whereNotNull('nomor_urut')->exists()) {
            return redirect()->route('admin.users.index')->with('error', 'Nomor urut sudah digenerate. Harap reset terlebih dahulu untuk generate ulang.');
        }

        // Get all verified participants, grouped by their education level.
        $pesertasByJenjang = Peserta::where('is_verified', true)->get()->groupBy('jenjang');

        DB::beginTransaction();
        try {
            foreach ($pesertasByJenjang as $jenjang => $pesertas) {
                $count = $pesertas->count();
                if ($count === 0) {
                    continue;
                }
                
                // Create a shuffled array of numbers from 1 to count.
                $nomorUrutPool = range(1, $count);
                shuffle($nomorUrutPool);

                // Assign the shuffled numbers to each participant in the group.
                foreach ($pesertas as $peserta) {
                    $peserta->nomor_urut = array_pop($nomorUrutPool);
                    $peserta->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')->with('error', 'Gagal generate nomor urut: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.users.index')->with('status', 'Berhasil generate nomor urut untuk semua peserta terverifikasi.');
    }

    /**
     * Reset all sequence numbers and schedules.
     */
    public function reset(): RedirectResponse
    {
        Peserta::query()->update([
            'nomor_urut' => null,
            'tanggal_tampil' => null,
            'tempat_tampil' => null,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Semua nomor urut dan jadwal berhasil direset.');
    }

    /**
     * Update the schedule for a specific participant.
     */
    public function updateJadwal(Request $request, Peserta $peserta): RedirectResponse
    {
        $request->validate([
            'tanggal_tampil' => ['nullable', 'date'],
            'tempat_tampil' => ['nullable', 'string', 'max:255'],
        ]);

        $peserta->update([
            'tanggal_tampil' => $request->input('tanggal_tampil'),
            'tempat_tampil' => $request->input('tempat_tampil'),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Jadwal untuk peserta ' . $peserta->nama_peserta . ' berhasil diperbarui.');
    }
}