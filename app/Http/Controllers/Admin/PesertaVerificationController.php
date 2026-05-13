<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::where('role', 'siswa')->latest()->paginate(10)->onEachSide(1);
        return view('admin.verifikasi.index', compact('users'));
    }

    /**
     * Activate the specified user account.
     */
    public function activate(User $user): RedirectResponse
    {
        if ($user->role === 'siswa') {
            $user->is_active = true;
            $user->save();
            return redirect()->route('admin.verifikasi.index')->with('status', 'Akun pengguna berhasil diaktifkan.');
        }
        return redirect()->route('admin.verifikasi.index')->with('error', 'Gagal mengaktifkan akun.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->role === 'siswa') {
            $user->delete();
            return redirect()->route('admin.verifikasi.index')->with('status', 'Akun pengguna berhasil dihapus.');
        }
        return redirect()->route('admin.verifikasi.index')->with('error', 'Gagal menghapus akun.');
    }
}
