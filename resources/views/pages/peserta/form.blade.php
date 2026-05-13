@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ isset($peserta) ? 'Edit Data Peserta Lomba' : 'Formulir Data Peserta Lomba' }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    
    {{-- Success Message --}}
    @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    {{-- Error Summary --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Terdapat kesalahan!</strong>
            <span class="block sm:inline">Mohon periksa kembali isian formulir Anda.</span>
        </div>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form action="{{ isset($peserta) ? route('peserta.update', $peserta->id) : route('peserta.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($peserta))
                @method('PUT')
            @endif

            <div class="shadow-md overflow-hidden sm:rounded-xl">
                
                {{-- Data Peserta Section --}}
                <div class="px-4 py-5 bg-background-alt sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">
                        <x-lucide-user-round class="inline-block w-5 h-5 mr-2" />
                        Data Peserta
                    </h3>
                    <div class="grid grid-cols-6 gap-6">
                        
                        {{-- Nama Peserta --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="nama_peserta" class="block text-sm font-medium text-gray-700">
                                Nama Peserta <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_peserta" 
                                   id="nama_peserta" 
                                   value="{{ old('nama_peserta', $peserta->nama_peserta ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('nama_peserta') border-red-500 @enderror">
                            @error('nama_peserta')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2 flex items-center space-x-4">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" 
                                           class="form-radio text-primary focus:ring-primary" 
                                           name="jenis_kelamin" 
                                           value="L" 
                                           {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}>
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" 
                                           class="form-radio text-primary focus:ring-primary" 
                                           name="jenis_kelamin" 
                                           value="P" 
                                           {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}>
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        {{-- Tempat Lahir --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="tempat_lahir" 
                                   id="tempat_lahir" 
                                   value="{{ old('tempat_lahir', $peserta->tempat_lahir ?? '') }}" 
                                   placeholder="Contoh: Jakarta" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('tempat_lahir') border-red-500 @enderror">
                            @error('tempat_lahir')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        {{-- Tanggal Lahir --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggal_lahir" 
                                   id="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('tanggal_lahir') border-red-500 @enderror">
                            @error('tanggal_lahir')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Jenjang Pendidikan --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="jenjang" class="block text-sm font-medium text-gray-700">
                                Jenjang Pendidikan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenjang" 
                                    id="jenjang" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('jenjang') border-red-500 @enderror">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SMP/MTS" {{ old('jenjang', $peserta->jenjang ?? '') == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS</option>
                                <option value="SMA/MA" {{ old('jenjang', $peserta->jenjang ?? '') == 'SMA/MA' ? 'selected' : '' }}>SMA/MA</option>
                            </select>
                            @error('jenjang')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="kelas" class="block text-sm font-medium text-gray-700">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="kelas" 
                                   id="kelas" 
                                   value="{{ old('kelas', $peserta->kelas ?? '') }}" 
                                   placeholder="Contoh: IX A" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('kelas') border-red-500 @enderror">
                            @error('kelas')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- No. HP Peserta --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="hp_peserta" class="block text-sm font-medium text-gray-700">
                                No. HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="hp_peserta" 
                                   id="hp_peserta" 
                                   value="{{ old('hp_peserta', $peserta->hp_peserta ?? '') }}" 
                                   placeholder="08xxxxxxxxxx"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('hp_peserta') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Contoh: 081234567890 (10-13 digit angka)</p>
                            @error('hp_peserta')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="col-span-6">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap sesuai domisili..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('alamat') border-red-500 @enderror">{{ old('alamat', $peserta->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Upload Foto Formal --}}
                        <div class="col-span-6" x-data="{photoPreview: null}">
                            <label for="foto_formal" class="block text-sm font-medium text-gray-700">
                                Upload Foto Formal 
                                @if(!isset($peserta) || !$peserta->foto_formal)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            
                            {{-- Current Photo --}}
                            @if(isset($peserta) && $peserta->foto_formal)
                                <div class="mt-2 mb-2" x-show="!photoPreview">
                                    <img src="{{ asset('storage/' . $peserta->foto_formal) }}" alt="Foto Peserta" class="h-56 w-44 object-cover rounded-md shadow-sm">
                                    <p class="text-xs text-gray-500 mt-1">Foto saat ini. Upload file baru untuk mengganti.</p>
                                </div>
                            @endif

                            {{-- New Photo Preview --}}
                            <div class="mt-2 mb-2" x-show="photoPreview" style="display: none;">
                                <img :src="photoPreview" alt="Preview Foto Baru" class="h-56 w-44 object-cover rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Pratinjau foto baru.</p>
                            </div>

                            <input type="file" 
                                   name="foto_formal" 
                                   id="foto_formal" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('foto_formal') border-red-500 @enderror"
                                   @if(!isset($peserta) || !$peserta- @endif
                                   @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => { photoPreview = e.target.result; };
                                            reader.readAsDataURL(file);
                                        }
                                   "
                            >
                            <p class="mt-1 text-sm text-gray-500">File harus berupa gambar (JPG, JPEG, PNG) maksimal 2MB.</p>
                            @error('foto_formal')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                {{-- Data Orang Tua Section --}}
                <div class="px-4 py-5 bg-background-alt sm:p-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">
                        <x-lucide-contact class="inline-block w-5 h-5 mr-2" />
                        Data Orang Tua / Wali
                    </h3>
                    <div class="grid grid-cols-6 gap-6">
                        
                        {{-- Nama Orang Tua --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="nama_ortu" class="block text-sm font-medium text-gray-700">
                                Nama Orang Tua <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_ortu" 
                                   id="nama_ortu" 
                                   value="{{ old('nama_ortu', $peserta->nama_ortu ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('nama_ortu') border-red-500 @enderror">
                            @error('nama_ortu')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- No. HP Orang Tua --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="hp_ortu" class="block text-sm font-medium text-gray-700">
                                No. HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="hp_ortu" 
                                   id="hp_ortu" 
                                   value="{{ old('hp_ortu', $peserta->hp_ortu ?? '') }}" 
                                   placeholder="08xxxxxxxxxx"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('hp_ortu') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Contoh: 081234567890 (10-13 digit angka)</p>
                            @error('hp_ortu')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Data Official Section --}}
                <div class="px-4 py-5 bg-background-alt sm:p-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">
                        <x-lucide-user-check class="inline-block w-5 h-5 mr-2" />
                        Data Official
                    </h3>
                    <div class="grid grid-cols-6 gap-6">
                        
                        {{-- Nama Official --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="nama_pengawas" class="block text-sm font-medium text-gray-700">
                                Nama Official <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_pengawas" 
                                   id="nama_pengawas" 
                                   value="{{ old('nama_pengawas', $peserta->nama_pengawas ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('nama_pengawas') border-red-500 @enderror">
                            @error('nama_pengawas')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- No. HP Official --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="hp_pengawas" class="block text-sm font-medium text-gray-700">
                                No. HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="hp_pengawas" 
                                   id="hp_pengawas" 
                                   value="{{ old('hp_pengawas', $peserta->hp_pengawas ?? '') }}" 
                                   placeholder="08xxxxxxxxxx"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('hp_pengawas') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Contoh: 081234567890 (10-13 digit angka)</p>
                            @error('hp_pengawas')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Data Lomba Section --}}
                <div class="px-4 py-5 bg-background-alt sm:p-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">
                        <x-lucide-mic class="inline-block w-5 h-5 mr-2" />
                        Data Lomba
                    </h3>
                    <div class="grid grid-cols-6 gap-6">
                        
                        {{-- Tema Pidato --}}
                        <div class="col-span-6">
                            <label for="tema_pidato" class="block text-sm font-medium text-gray-700">
                                Tema Pidato <span class="text-red-500">*</span>
                            </label>
                            <textarea id="tema_pidato" 
                                      name="tema_pidato" 
                                      rows="4" 
                                      placeholder="Masukkan tema pidato yang akan dibawakan..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm @error('tema_pidato') border-red-500 @enderror">{{ old('tema_pidato', $peserta->tema_pidato ?? '') }}</textarea>
                            @error('tema_pidato')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" 
                            class="inline-flex justify-center rounded-md border border-transparent bg-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <x-lucide-save class="w-4 h-4 mr-2" />
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
