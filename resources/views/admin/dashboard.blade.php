<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-2 md:space-y-0">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
                    <x-lucide-layout-dashboard class="w-7 h-7 text-primary mr-3" />
                    {{ __('Dashboard Ringkasan') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Sistem Pemantauan dan Pengingat Pembayaran Pensiunan ASABRI - Bank Syariah Indonesia</p>
            </div>
            <div class="text-sm text-gray-600 text-left md:text-right">
                Hari ini: <span class="font-semibold text-primary">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Widget -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6 relative">
                <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-primary/10 to-transparent pointer-events-none hidden md:block"></div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Selamat Datang Kembali, Admin!</h3>
                        <p class="text-gray-600 mt-1">Kelola data pensiunan, kirim pengingat jatuh tempo melalui WhatsApp, dan pantau status transaksi dengan mudah.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.reminders.create') }}" class="bg-accent hover:bg-accent-dark text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-accent/20 transition duration-150 ease-in-out flex items-center gap-2 transform hover:-translate-y-0.5">
                            <x-lucide-bell class="w-4 h-4" />
                            Kirim Reminder
                        </a>
                        <a href="{{ route('admin.pensioners.create') }}" class="bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-primary/20 transition duration-150 ease-in-out flex items-center gap-2 transform hover:-translate-y-0.5">
                            <x-lucide-user-plus class="w-4 h-4" />
                            Tambah Pensiunan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Pensioners -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition duration-200">
                    <div class="p-4 rounded-xl bg-primary/10 text-primary">
                        <x-lucide-users class="w-8 h-8" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Pensiunan</p>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalPensioners }}</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Pengguna terdaftar</p>
                    </div>
                </div>

                <!-- Due (Jatuh Tempo) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition duration-200">
                    <div class="p-4 rounded-xl bg-red-100 text-red-600">
                        <x-lucide-alert-circle class="w-8 h-8" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Jatuh Tempo</p>
                        <h4 class="text-3xl font-extrabold text-red-600 mt-1">{{ $totalJatuhTempo }}</h4>
                        <p class="text-xs text-red-500 font-medium mt-0.5">Harus segera dibayar</p>
                    </div>
                </div>

                <!-- Approaching (Mendekati) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition duration-200">
                    <div class="p-4 rounded-xl bg-amber-100 text-amber-600">
                        <x-lucide-clock class="w-8 h-8" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Mendekati Tempo</p>
                        <h4 class="text-3xl font-extrabold text-amber-600 mt-1">{{ $mendekati }}</h4>
                        <p class="text-xs text-amber-500 font-medium mt-0.5">Tempo ≤ 7 Hari</p>
                    </div>
                </div>

                <!-- Reminders Sent -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4 hover:shadow-md transition duration-200">
                    <div class="p-4 rounded-xl bg-blue-100 text-blue-600">
                        <x-lucide-send class="w-8 h-8" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Notifikasi</p>
                        <h4 class="text-3xl font-extrabold text-blue-600 mt-1">{{ $totalNotifikasi }}</h4>
                        <p class="text-xs text-green-600 font-semibold mt-0.5">
                            @if($totalNotifikasi > 0)
                                {{ number_format(($notifikasiSukses / $totalNotifikasi) * 100, 1) }}% Sukses
                            @else
                                0% Sukses
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Pensioners List -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <x-lucide-user-check class="w-5 h-5 text-primary mr-2" />
                            Pensiunan Terbaru
                        </h3>
                        <a href="{{ route('admin.pensioners.index') }}" class="text-sm text-primary hover:text-primary-dark font-semibold">
                            Lihat Semua &rarr;
                        </a>
                    </div>
                    <div class="divide-y divide-gray-100 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama & NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Instansi</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($recentPensioners as $pensioner)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 bg-primary/10 text-primary flex items-center justify-center rounded-full font-bold">
                                                    {{ strtoupper(substr($pensioner->nama, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $pensioner->nama }}</div>
                                                    <div class="text-xs text-gray-500">NIP: {{ $pensioner->nip }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            {{ $pensioner->instansi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            {{ $pensioner->tanggal_jatuh_tempo->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                {{ $pensioner->status_color === 'red' ? 'bg-red-50 text-red-700' : ($pensioner->status_color === 'yellow' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700') }}">
                                                {{ $pensioner->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data pensiunan terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BSI Branding Card -->
                <div class="bg-gradient-to-br from-primary to-primary-dark text-white rounded-2xl p-8 flex flex-col justify-center items-center text-center shadow-xl relative overflow-hidden h-full min-h-[300px]">
                    <!-- Background shapes -->
                    <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -left-12 -top-12 w-40 h-40 bg-accent/20 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col items-center space-y-6 w-full">
                        <div class="bg-white p-3 rounded-2xl shadow-lg border-2 border-white/20 transform hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('logo-bsi.png') }}" class="h-16 w-auto object-contain" alt="BSI Logo" />
                        </div>
                        <div>
                            <h2 class="font-extrabold text-2xl tracking-widest text-white drop-shadow-md mb-3 uppercase">BSI KC Langsa</h2>
                            <div class="w-16 h-1 bg-accent mx-auto rounded-full mb-4 opacity-80"></div>
                            <h3 class="text-xl font-bold leading-relaxed text-white/95 drop-shadow">
                                Integrasi Layanan<br>Pensiunan ASABRI
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
