@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manajemen Data Peserta
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" x-data="{ 
    open: false, 
    selectedPeserta: null,
    notification: {
        show: false,
        message: '',
        type: 'success'
    },
    showConfirmModal: false,
    confirmAction: '',
    confirmTitle: '',
    confirmMessage: ''
}"
x-init="
    @if (session('status'))
        notification.show = true;
        notification.message = '{{ session('status') }}';
        notification.type = 'success';
        setTimeout(() => notification.show = false, 4000);
    @endif
    @if (session('error'))
        notification.show = true;
        notification.message = '{{ session('error') }}';
        notification.type = 'error';
        setTimeout(() => notification.show = false, 4000);
    @endif
">

    <!-- Toast Notification - Enhanced -->
    <div x-show="notification.show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-2 scale-95"
         :class="{
             'bg-green-500': notification.type === 'success',
             'bg-red-500': notification.type === 'error'
         }"
         class="fixed top-5 right-5 z-50 rounded-xl px-6 py-4 shadow-2xl text-white min-w-[300px] max-w-md"
         style="display: none;">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <svg x-show="notification.type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <svg x-show="notification.type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="font-medium" x-text="notification.message"></p>
            <button @click="notification.show = false" class="ml-auto flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Peserta</p>
                    <p class="text-3xl font-bold mt-2 text-gray-800">{{ $totalPeserta }}</p>
                </div>
                <div class="bg-gray-100 rounded-full p-4">
                    <x-lucide-users class="w-8 h-8 text-gray-600"/>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Sudah Diverifikasi</p>
                    <p class="text-3xl font-bold mt-2 text-green-600">{{ $verifiedCount }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <x-lucide-user-check class="w-8 h-8 text-green-600"/>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Belum Diverifikasi</p>
                    <p class="text-3xl font-bold mt-2 text-red-600">{{ $unverifiedCount }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-4">
                    <x-lucide-user-cog class="w-8 h-8 text-red-600"/>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="bg-secondary p-4 sm:flex sm:justify-between sm:items-center">
            <div class="flex-1">
                <h3 class="text-gray-900 font-semibold text-lg">Manajemen Peserta & Jadwal</h3>
            </div>
            <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center space-x-2">
                    <select name="jenjang" id="jenjang" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                        <option value="">Semua Jenjang</option>
                        <option value="SMP/MTS" @if(request('jenjang') == 'SMP/MTS') selected @endif>SMP/MTS</option>
                        <option value="SMA/MA" @if(request('jenjang') == 'SMA/MA') selected @endif>SMA/MA</option>
                    </select>
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm">
                        <x-lucide-filter class="w-4 h-4 mr-1"/>
                        Filter
                    </button>
                </form>
            </div>
        </div>
        <div class="p-4 sm:flex sm:justify-between sm:items-center">
            <div class="flex items-center space-x-2">
                <form id="generateForm" action="{{ route('admin.nomor-urut.generate') }}" method="POST">
                    @csrf
                    <button type="button" 
                            @click="
                                confirmTitle = 'Konfirmasi Generate Nomor Urut';
                                confirmMessage = 'Apakah Anda yakin ingin generate nomor urut? Tindakan ini tidak bisa dibatalkan kecuali direset.';
                                confirmAction = () => document.getElementById('generateForm').submit();
                                showConfirmModal = true;
                            "
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">
                        <x-lucide-list-ordered class="w-4 h-4 mr-2" />
                        Generate No. Urut
                    </button>
                </form>
                <form id="resetForm" action="{{ route('admin.nomor-urut.reset') }}" method="POST">
                    @csrf
                    <button type="button" 
                            @click="
                                confirmTitle = 'Konfirmasi Reset';
                                confirmMessage = 'PERINGATAN: Tindakan ini akan menghapus semua nomor urut dan jadwal yang ada. Lanjutkan?';
                                confirmAction = () => document.getElementById('resetForm').submit();
                                showConfirmModal = true;
                            "
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">
                         <x-lucide-rotate-ccw class="w-4 h-4 mr-2" />
                        Reset
                    </button>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Urut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peserta</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenjang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal Sekolah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pesertas as $peserta)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $peserta->nomor_urut ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $peserta->nama_peserta }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $peserta->jenjang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $peserta->user->asal_sekolah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($peserta->is_verified)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Verifikasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                <button @click="selectedPeserta = {{ json_encode($peserta) }}; open = true" class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white px-3 py-1 rounded-md text-xs">Detail</button>
                                 @unless ($peserta->is_verified)
                                    <form action="{{ route('admin.users.verify', $peserta) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="border border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white px-3 py-1 rounded-md text-xs">Verifikasi</button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data peserta untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden">
            <div class="p-4 space-y-4">
                @forelse ($pesertas as $peserta)
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-base text-gray-900">{{ $peserta->nama_peserta }}</p>
                                <p class="text-sm text-gray-500">{{ $peserta->jenjang }} - {{ $peserta->user->asal_sekolah }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    No. Urut: <span class="font-semibold">{{ $peserta->nomor_urut ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                 @if ($peserta->is_verified)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end items-center space-x-2">
                             <button @click="selectedPeserta = {{ json_encode($peserta) }}; open = true" class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white px-3 py-1 rounded-md text-xs">Detail</button>
                             @unless ($peserta->is_verified)
                                <form action="{{ route('admin.users.verify', $peserta) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="border border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white px-3 py-1 rounded-md text-xs">Verifikasi</button>
                                </form>
                            @endunless
                        </div>
                    </div>
                @empty
                     <div class="text-center py-8">
                        <p class="text-sm text-gray-500">Tidak ada data peserta untuk diverifikasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="p-4 flex justify-center sm:justify-between items-center bg-gray-50 border-t border-gray-200">
            {{ $pesertas->links() }}
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showConfirmModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4" 
         style="display: none;">
        <div @click.away="showConfirmModal = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h3 class="text-xl font-bold text-gray-800" x-text="confirmTitle"></h3>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700" x-text="confirmMessage"></p>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button @click="showConfirmModal = false" 
                        type="button" 
                        class="px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <button @click="confirmAction(); showConfirmModal = false;"
                        type="button" 
                        class="px-5 py-2.5 bg-primary text-white rounded-lg hover:bg-primary-dark font-semibold transition-all duration-200 shadow-md">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-500 bg-opacity-75" 
         x-cloak 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-full max-h-[90vh] flex flex-col" @click.away="open = false">
            <!-- Modal Header -->
            <div class="flex justify-between items-center bg-secondary p-4 print:hidden">
                <h3 class="text-gray-900 font-semibold text-lg">Rincian Data Peserta</h3>
                <button @click="open = false" class="text-gray-700 hover:text-gray-900">&times;</button>
            </div>

            <!-- Modal Body -->
            <div id="printable-area" class="p-6 overflow-y-auto">
                <div x-if="selectedPeserta">
                    <div class="flex flex-col md:flex-row gap-8">
                        {{-- Foto & Data Kiri --}}
                        <div class="w-full md:w-1/3 text-center md:text-left">
                            <p class="text-sm text-gray-500 mb-2 print:hidden">Foto Peserta</p>
                             <img :src="selectedPeserta.foto_formal ? '/storage/' + selectedPeserta.foto_formal : 'https://via.placeholder.com/150'" 
                                 alt="Foto Peserta" 
                                 class="rounded-lg shadow-md w-48 h-auto mx-auto md:mx-0">
                            
                            <div class="mt-6 space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nama Peserta</p>
                                    <p class="font-semibold text-lg" x-text="selectedPeserta.nama_peserta"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Asal Sekolah</p>
                                    <p class="font-medium" x-text="selectedPeserta.user.asal_sekolah"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">NISN</p>
                                    <p class="font-medium" x-text="selectedPeserta.user.nisn"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Data Kanan --}}
                        <div class="w-full md:w-2/3 space-y-6">
                           <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                                        <p class="font-medium" x-text="selectedPeserta.tempat_lahir + ', ' + new Date(selectedPeserta.tanggal_lahir).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Usia</p>
                                        <p class="font-medium" x-text="selectedPeserta.usia + ' Tahun'"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Jenis Kelamin</p>
                                        <p class="font-medium" x-text="selectedPeserta.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'"></p>
                                    </div>
                                     <div>
                                        <p class="text-sm text-gray-500">Kelas</p>
                                        <p class="font-medium" x-text="selectedPeserta.kelas"></p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                     <div>
                                        <p class="text-sm text-gray-500">No. HP Peserta</p>
                                        <p class="font-medium" x-text="selectedPeserta.hp_peserta"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Nama Orang Tua</p>
                                        <p class="font-medium" x-text="selectedPeserta.nama_ortu"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">No. HP Orang Tua</p>
                                        <p class="font-medium" x-text="selectedPeserta.hp_ortu"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Jenjang</p>
                                        <p class="font-medium" x-text="selectedPeserta.jenjang"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Alamat</p>
                                        <p class="font-medium" x-text="selectedPeserta.alamat"></p>
                                    </div>
                                </div>
                           </div>
                           <div class="border-t pt-4">
                               <p class="text-sm text-gray-500">Tema Pidato Pilihan</p>
                               <p class="font-medium whitespace-pre-wrap" x-text="selectedPeserta.tema_pidato"></p>
                           </div>

                            <div class="border-t pt-4 mt-4">
                                <h4 class="text-md font-semibold text-gray-800 mb-3">Jadwal Tampil</h4>
                                <div class="space-y-2 mb-4">
                                    <p class="text-sm">
                                        <span class="text-gray-500">Nomor Urut:</span>
                                        <span class="font-bold text-lg ml-2" x-text="selectedPeserta.nomor_urut ? selectedPeserta.nomor_urut : 'Belum digenerate'"></span>
                                    </p>
                                </div>
                                <form :action="'/admin/peserta/' + selectedPeserta.id + '/jadwal'" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="tanggal_tampil" class="block text-sm font-medium text-gray-700">Tanggal Tampil</label>
                                            <input type="date" name="tanggal_tampil" id="tanggal_tampil" :value="selectedPeserta.tanggal_tampil" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="tempat_tampil" class="block text-sm font-medium text-gray-700">Tempat Tampil</label>
                                            <input type="text" name="tempat_tampil" id="tempat_tampil" :value="selectedPeserta.tempat_tampil" placeholder="Contoh: Aula Polres" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                        </div>
                                    </div>
                                    <div class="text-right mt-4">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark text-sm">
                                            <x-lucide-save class="w-4 h-4 mr-2" />
                                            Simpan Jadwal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="bg-gray-100 p-4 flex justify-end items-center space-x-4 print:hidden">
                <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Tutup</button>
                <a :href="'/admin/peserta/' + selectedPeserta.id + '/pdf'" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                    <x-lucide-download class="w-4 h-4 mr-2" />
                    Unduh PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
