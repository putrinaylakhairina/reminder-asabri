@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Jadwal dan Data Peserta
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Detail Peserta dan Jadwal Lomba</h3>
            
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nama Peserta</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $peserta->nama_peserta }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nomor Registrasi</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $peserta->user->nomor_registrasi }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Jenjang</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $peserta->jenjang }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nomor Urut Tampil</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $peserta->nomor_urut ?? 'Belum ditentukan' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Tampil</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $peserta->tanggal_tampil ? \Carbon\Carbon::parse($peserta->tanggal_tampil)->isoFormat('dddd, D MMMM Y') : 'Belum ditentukan' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tempat Tampil</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $peserta->tempat_tampil ?? 'Belum ditentukan' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tema Pidato Pilihan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ $peserta->tema_pidato }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
