<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pribadi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Halo, {{ $pensioner->nama }}!</h3>
                            <p class="text-gray-600">Selamat datang di sistem pengingat ASABRI.</p>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-2 rounded-full font-bold text-sm
                                {{ $pensioner->status_color === 'red' ? 'bg-red-100 text-red-800' : ($pensioner->status_color === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                Status: {{ $pensioner->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t pt-8">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Informasi Pribadi</h4>
                                <p class="text-lg font-medium">{{ $pensioner->nama }}</p>
                                <p class="text-sm text-gray-600">NIP: {{ $pensioner->nip }}</p>
                                <p class="text-sm text-gray-600">Instansi: {{ $pensioner->instansi }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</h4>
                                <p class="text-sm text-gray-600">Email: {{ $pensioner->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Pembayaran</h4>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-sm text-gray-600">Gaji Pensiun</p>
                                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($pensioner->gaji_pensiun, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-600">Tanggal Jatuh Tempo Berikutnya:</p>
                                    <p class="text-xl font-bold {{ $pensioner->status_color === 'red' ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $pensioner->tanggal_jatuh_tempo->format('d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($pensioner->status === 'jatuh_tempo' || $pensioner->status === 'mendekati')
                        <div class="mt-8 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                            <p class="font-bold">Perhatian!</p>
                            <p>Pembayaran dana pensiun Anda {{ $pensioner->status === 'jatuh_tempo' ? 'sudah jatuh tempo' : 'akan segera jatuh tempo' }}. Mohon pastikan data Anda sudah benar atau hubungi admin jika ada kendala.</p>
                        </div>
                    @endif

                    <!-- Recent Notification History -->
                    <div class="mt-12">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <x-lucide-history class="w-5 h-5 mr-2" />
                            Riwayat Notifikasi Terakhir
                        </h4>
                        <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saluran</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($history as $log)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $log->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium uppercase">
                                                {{ str_replace('_sent', '', $log->status) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">
                                                    Berhasil
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada riwayat notifikasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
