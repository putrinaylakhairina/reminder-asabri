@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="text-sm text-gray-600 text-left sm:text-right break-words">
            {{ __('Selamat datang,') }} <span class="font-semibold text-gray-800">{{ Auth::user()->nama }}</span>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card untuk informasi pengguna -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-6">
                <div class="bg-secondary p-4">
                    <h3 class="text-gray-900 font-semibold text-lg">{{ __('Informasi Pengguna') }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Dasar -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Nama') }}</p>
                                    <p class="font-medium">{{ Auth::user()->nama }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Nomor Registrasi') }}</p>
                                    <p class="font-medium">{{ Auth::user()->nomor_registrasi }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Asal Sekolah') }}</p>
                                    <p class="font-medium">{{ Auth::user()->asal_sekolah }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Informasi Tambahan -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('NISN') }}</p>
                                    <p class="font-medium">{{ Auth::user()->nisn }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Role') }}</p>
                                    <p class="font-medium">
                                        @if(Auth::user()->role === 'admin')
                                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Admin</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Siswa</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Status Akun') }}</p>
                                    <p class="font-medium">
                                        @if(Auth::user()->is_active)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $peserta = Auth::user()->peserta;
            @endphp

            @if(Auth::user()->role !== 'admin' && $peserta)
            <!-- Card untuk Informasi Lomba -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-6">
                <div class="bg-secondary p-4">
                    <h3 class="text-gray-900 font-semibold text-lg">{{ __('Informasi Lomba') }}</h3>
                </div>
                <div class="p-6">
                    @if($peserta->nomor_urut)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            <div>
                                <p class="text-sm text-gray-500">Nomor Urut</p>
                                <p class="font-bold text-4xl text-primary mt-1">{{ $peserta->nomor_urut }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Tampil</p>
                                <p class="font-semibold text-lg text-gray-800 mt-2">
                                    {{ $peserta->tanggal_tampil ? \Carbon\Carbon::parse($peserta->tanggal_tampil)->isoFormat('dddd, D MMMM Y') : 'Belum ditentukan' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tempat Tampil</p>
                                <p class="font-semibold text-lg text-gray-800 mt-2">{{ $peserta->tempat_tampil ?? 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-gray-500">
                            <x-lucide-loader class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Jadwal Belum Tersedia</h3>
                            <p class="mt-1 text-sm text-gray-500">Nomor urut dan jadwal tampil Anda sedang diproses oleh panitia.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Card untuk pesan selamat datang -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang! Anda telah berhasil masuk ke sistem.") }}
                </div>
            </div>
        </div>
    </div>
@endsection