@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manajemen Verifikasi Akun
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8" 
     x-data="{ 
         showModal: false, 
         deleteUrl: '',
         deleteName: '',
         notification: {
             show: false,
             message: '',
             type: 'success'
         }
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold mt-2 text-gray-800">{{ $users->total() }}</p>
                </div>
                <div class="bg-gray-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Akun Aktif</p>
                    <p class="text-3xl font-bold mt-2 text-green-600">{{ $users->where('is_active', true)->count() }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold mt-2 text-red-600">{{ $users->where('is_active', false)->count() }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
        <!-- Header -->
        <div class="bg-secondary p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-lg p-2 shadow-sm">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-900 font-bold text-xl">Verifikasi Akun Pengguna</h3>
                        <p class="text-gray-600 text-sm">Kelola dan verifikasi akun pendaftar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Nama</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <span>Nomor Registrasi</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aktivasi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Hapus</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold">
                                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->nama }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono bg-gray-100 px-3 py-1 rounded-lg inline-block">
                                    {{ $user->nomor_registrasi }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->is_active)
                                    <span class="px-3 py-1.5 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @unless ($user->is_active)
                                    <form action="{{ route('admin.verifikasi.activate', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg text-sm font-semibold transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Aktifkan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm italic">Sudah aktif</span>
                                @endunless
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button @click="showModal = true; deleteUrl = '{{ route('admin.verifikasi.destroy', $user) }}'; deleteName = '{{ $user->nama }}'" 
                                        type="button" 
                                        class="inline-flex items-center px-4 py-2 border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-sm font-semibold transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada data pengguna</p>
                                    <p class="text-gray-400 text-sm mt-1">Belum ada pengguna yang terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View - Enhanced -->
        <div class="md:hidden">
            <div class="p-4 space-y-4">
                @forelse ($users as $user)
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 p-5 border border-gray-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3 flex-1">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold text-lg shadow-md">
                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-base text-gray-900 truncate">{{ $user->nama }}</p>
                                    <p class="text-sm text-gray-500 font-mono bg-gray-100 px-2 py-0.5 rounded inline-block mt-1">{{ $user->nomor_registrasi }}</p>
                                </div>
                            </div>
                            <div class="ml-2">
                                @if ($user->is_active)
                                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                            @unless ($user->is_active)
                                <form action="{{ route('admin.verifikasi.activate', $user) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg text-sm font-semibold transition-all duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Aktifkan
                                    </button>
                                </form>
                            @endunless
                            <button @click="showModal = true; deleteUrl = '{{ route('admin.verifikasi.destroy', $user) }}'; deleteName = '{{ $user->nama }}'" 
                                    type="button" 
                                    class="@unless($user->is_active) flex-1 @else w-full @endunless inline-flex items-center justify-center px-3 py-2 border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-sm font-semibold transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">Tidak ada data pengguna</p>
                        <p class="text-gray-400 text-sm mt-1">Belum ada pengguna yang terdaftar</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-4 py-4 border-t border-gray-200 flex justify-center sm:justify-between items-center">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal - Enhanced -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4" 
         style="display: none;">
        <div @click.away="showModal = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-red-600 px-6 py-5">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 bg-white/20 rounded-full p-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Konfirmasi Hapus</h3>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-900 font-medium mb-2">Apakah Anda yakin ingin menghapus akun ini?</p>
                        <div class="bg-gray-100 rounded-lg p-3 mb-3">
                            <p class="text-sm text-gray-600 mb-1">Akun yang akan dihapus:</p>
                            <p class="text-base font-bold text-gray-900" x-text="deleteName"></p>
                        </div>
                        <p class="text-sm text-red-600 font-medium">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Tindakan ini tidak dapat diurungkan!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button @click="showModal = false" 
                        type="button" 
                        class="px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <form :action="deleteUrl" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Reinitialize icons if using Lucide
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection