<div class="space-y-6">
    
    <div>
        <x-input-label for="nama" :value="__('Nama')"/>
        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $jabatan?->nama)" autocomplete="nama" placeholder="Nama"/>
        <x-input-error class="mt-2" :messages="$errors->get('nama')"/>
    </div>
    <div>
        <x-input-label for="deskripsi" :value="__('Deskripsi')"/>
        <textarea name="deskripsi" id="deskripsi" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="deskripsi jabatan">{{ old('deskripsi', $jabatan?->deskripsi) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('deskripsi')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>