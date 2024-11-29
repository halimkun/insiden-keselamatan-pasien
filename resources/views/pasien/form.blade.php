<div class="space-y-6">

    <div>
        <x-input-label for="nama" :value="__('Nama Pasien')" />
        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $pasien?->nama)" autocomplete="nama" placeholder="Nama pasien" />

        <x-input-error class="mt-2" :messages="$errors->get('nama')" />
    </div>

    <div class="flex gap-6">
        <div class="w-full">
            <x-input-label for="no_rekam_medis" :value="__('No Rekam Medis')" />
            <x-text-input id="no_rekam_medis" name="no_rekam_medis" type="text" class="mt-1 block w-full" :value="old('no_rekam_medis', $pasien?->no_rekam_medis)" autocomplete="no_rekam_medis" placeholder="No Rekam Medis" inputmode="numeric" />

            <x-input-error class="mt-2" :messages="$errors->get('no_rekam_medis')" />
        </div>

        <div class="w-full">
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir', $pasien?->tanggal_lahir?->format('Y-m-d'))" autocomplete="tanggal_lahir" placeholder="Tanggal Lahir" />

            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        </div>

        <div class="w-full">
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenis_kelamin', $pasien?->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $pasien?->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>


            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
        </div>
    </div>

    <div>
        <x-input-label for="alamat" :value="__('Alamat')" />
        <textarea name="alamat" id="alamat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Alamat">{{ old('alamat', $pasien?->alamat) }}</textarea>

        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
    </div>
    <div>
        <x-input-label for="penanggung_biaya_id" :value="__('Penanggung Biaya')" />
        <select name="penanggung_biaya_id" id="penanggung_biaya_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            <option value="">-- Pilih Penanggung Biaya --</option>
            @foreach ($penanggungBiaya as $item)
                <option value="{{ $item->id }}" {{ old('penanggung_biaya_id', $pasien?->penanggung_biaya_id) == $item->id ? 'selected' : '' }}>{{ $item->jenis_penanggung }}</option>
            @endforeach
        </select>

        <x-input-error class="mt-2" :messages="$errors->get('penanggung_biaya_id')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
