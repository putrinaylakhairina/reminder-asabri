<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pensiunan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.pensioners.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nip" :value="__('NIP')" />
                                <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" required />
                                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="instansi" :value="__('Instansi')" />
                                <x-text-input id="instansi" class="block mt-1 w-full" type="text" name="instansi" :value="old('instansi')" required />
                                <x-input-error :messages="$errors->get('instansi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="gaji_pensiun" :value="__('Gaji Pensiun (Rp)')" />
                                <x-text-input id="gaji_pensiun" class="block mt-1 w-full" type="number" name="gaji_pensiun" :value="old('gaji_pensiun')" required />
                                <x-input-error :messages="$errors->get('gaji_pensiun')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_jatuh_tempo" :value="__('Tanggal Jatuh Tempo')" />
                                <x-text-input id="tanggal_jatuh_tempo" class="block mt-1 w-full" type="date" name="tanggal_jatuh_tempo" :value="old('tanggal_jatuh_tempo')" required />
                                <x-input-error :messages="$errors->get('tanggal_jatuh_tempo')" class="mt-2" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
