@extends('layouts.app')

@section('header')
    <div class="bg-secondary py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal dan Data Peserta
            </h2>
        </div>
    </div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 transform hover:scale-[1.01] transition-transform duration-300">
        <!-- Header Card -->
        <div class="bg-secondary p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-white rounded-lg p-2 shadow-sm">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-900 font-bold text-xl">Detail Peserta Lomba</h3>
                    <p class="text-gray-600 text-sm mt-1">Informasi lengkap jadwal dan data peserta</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-6">
            <div class="space-y-1 divide-y divide-gray-100">
                <!-- Nama Peserta -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider sm:w-1/3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Nama Peserta
                        </dt>
                        <dd class="mt-2 sm:mt-0 text-base text-gray-900 font-semibold sm:w-2/3">{{ $peserta->nama_peserta }}</dd>
                    </div>
                </div>

                <!-- Nomor Registrasi -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider sm:w-1/3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            Nomor Registrasi
                        </dt>
                        <dd class="mt-2 sm:mt-0 text-base text-gray-900 font-mono font-medium sm:w-2/3">
                            <span class="bg-gray-100 px-3 py-1 rounded-lg inline-block">
                                {{ $peserta->user->nomor_registrasi }}
                            </span>
                        </dd>
                    </div>
                </div>

                <!-- Jenjang -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider sm:w-1/3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Jenjang
                        </dt>
                        <dd class="mt-2 sm:mt-0 text-base text-gray-900 font-semibold sm:w-2/3">
                            {{ $peserta->jenjang }}
                        </dd>
                    </div>
                </div>

                <!-- Nomor Urut -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider sm:w-1/3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Nomor Urut Tampil
                        </dt>
                        <dd class="mt-2 sm:mt-0 text-base sm:w-2/3">
                            @if($peserta->nomor_urut)
                                <span class="bg-gray-100 text-gray-900 px-4 py-1 rounded-lg text-lg font-bold inline-block">
                                    {{ str_pad($peserta->nomor_urut, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm italic">
                                    Belum ditentukan
                                </span>
                            @endif
                        </dd>
                    </div>
                </div>

                <!-- Tanggal Tampil -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider sm:w-1/3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Tanggal Tampil
                        </dt>
                        <dd class="mt-2 sm:mt-0 text-base text-gray-900 font-semibold sm:w-2/3">
                            @if($peserta->tanggal_tampil)
                                {{ \Carbon\Carbon::parse($peserta->tanggal_tampil)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                <span class="text-gray-500 text-sm italic">
                                    Belum ditentukan
                                </span>
                            @endif
                        </dd>
                    </div>
                </div>

                <!-- Tempat Tampil -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider sm:w-1/3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Tempat Tampil
                        </dt>
                        <dd class="mt-2 sm:mt-0 text-base text-gray-900 font-semibold sm:w-2/3">
                            {{ $peserta->tempat_tampil ?? 'Belum ditentukan' }}
                        </dd>
                    </div>
                </div>

                <!-- Tema Pidato -->
                <div class="py-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-4 -mx-4">
                    <div class="flex flex-col">
                        <dt class="flex items-center text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Tema Pidato Pilihan
                        </dt>
                        <dd class="mt-1 text-base text-gray-900 bg-gray-50 border-l-4 border-gray-400 p-4 rounded-r-lg">
                            <p class="whitespace-pre-wrap leading-relaxed">{{ $peserta->tema_pidato }}</p>
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection