<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reminder Asabri') }}
            </h2>
            <a href="{{ route('admin.reminders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                + Buat Reminder
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats & Actions -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Reminder</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $pendingCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Terkirim</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $sentCount }}</div>
                </div>
                <div class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 transition-colors cursor-pointer rounded-lg shadow-lg text-white font-bold"
                     onclick="document.getElementById('generate-form').submit()">
                    <form id="generate-form" action="{{ route('admin.reminders.generate') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>Generate Otomatis</span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form action="{{ route('admin.reminders.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama atau NIP..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <select name="status" class="rounded-lg border-gray-300">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sent" {{ $currentStatus == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="failed" {{ $currentStatus == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ $currentStatus == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                        Filter
                    </button>
                    @if($search || $currentStatus)
                        <a href="{{ route('admin.reminders.index') }}" class="text-sm text-blue-600 hover:underline">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Reminder Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pensiunan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe & Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Kirim</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reminders as $reminder)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $reminder->pensioner->nama }}</div>
                                        <div class="text-xs text-gray-500">NIP: {{ $reminder->pensioner->nip }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800 mr-2">
                                                {{ strtoupper($reminder->type) }}
                                            </span>
                                            <span class="text-sm text-gray-700">{{ $reminder->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reminder->remind_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'sent' => 'bg-green-100 text-green-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                                'cancelled' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Pending',
                                                'sent' => 'Terkirim',
                                                'failed' => 'Gagal',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$reminder->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$reminder->status] ?? ucfirst($reminder->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        @if($reminder->status === 'pending')
                                            <form action="{{ route('admin.reminders.send', $reminder) }}" method="POST" class="inline" onsubmit="return confirm('Kirim reminder ini via Email & WhatsApp?')">
                                                @csrf
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-semibold">Kirim</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.reminders.destroy', $reminder) }}" method="POST" class="inline" onsubmit="return confirm('Hapus reminder ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        Tidak ada reminder ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($reminders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $reminders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
