<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Pensiunan') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pensioners.export-pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                    Export PDF
                </a>
                <a href="{{ route('admin.pensioners.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                    Tambah Pensiunan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.pensioners.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                        <div class="flex flex-col">
                            <label for="status" class="text-sm font-medium text-gray-700">Filter Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                                <option value="mendekati" {{ request('status') == 'mendekati' ? 'selected' : '' }}>Mendekati</option>
                                <option value="jatuh_tempo" {{ request('status') == 'jatuh_tempo' ? 'selected' : '' }}>Jatuh Tempo</option>
                            </select>
                        </div>
                        <div class="flex items-end h-full mt-6">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                                Filter
                            </button>
                            @if(request('status'))
                                <a href="{{ route('admin.pensioners.index') }}" class="ml-2 text-sm text-blue-600 hover:underline">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instansi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pensioners as $pensioner)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pensioner->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pensioner->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pensioner->instansi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pensioner->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $color = $pensioner->status_color;
                                            $label = $pensioner->status_label;
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $color === 'red' ? 'bg-red-100 text-red-800' : ($color === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                        <a href="{{ route('admin.pensioners.edit', $pensioner) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('admin.pensioners.destroy', $pensioner) }}" method="POST" onsubmit="event.preventDefault(); Swal.fire({title: 'Konfirmasi Hapus', text: 'Apakah Anda yakin ingin menghapus data ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'}).then((result) => { if (result.isConfirmed) { this.submit(); } });">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pensiunan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $pensioners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
