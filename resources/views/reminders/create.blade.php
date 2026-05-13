<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Reminder Baru') }}
            </h2>
            <a href="{{ route('admin.reminders.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.reminders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Pensioner -->
                        <div>
                            <label for="pensioner_id" class="block text-sm font-medium text-gray-700">Pensiunan <span class="text-red-500">*</span></label>
                            <select name="pensioner_id" id="pensioner_id" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Pensiunan --</option>
                                @foreach($pensioners as $pensioner)
                                    <option value="{{ $pensioner->id }}" {{ old('pensioner_id') == $pensioner->id ? 'selected' : '' }}>
                                        {{ $pensioner->nama }} (NIP: {{ $pensioner->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pensioner_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Reminder <span class="text-red-500">*</span></label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="authentication" {{ old('type') == 'authentication' ? 'selected' : '' }}>Otentikasi</option>
                                <option value="payment" {{ old('type') == 'payment' ? 'selected' : '' }}>Pembayaran</option>
                                <option value="renewal" {{ old('type') == 'renewal' ? 'selected' : '' }}>Perpanjangan</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                                   placeholder="Contoh: Otentikasi Tahunan Diperlukan"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                      placeholder="Detail informasi reminder..."
                                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remind At -->
                        <div>
                            <label for="remind_at" class="block text-sm font-medium text-gray-700">Jadwal Kirim <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="remind_at" id="remind_at" required value="{{ old('remind_at') }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('remind_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.reminders.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition duration-150 ease-in-out">
                                Simpan Reminder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
