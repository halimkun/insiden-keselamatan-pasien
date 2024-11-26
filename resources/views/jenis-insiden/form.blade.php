<div class="space-y-6">
    
    <div>
        <x-input-label for="nama_jenis_insiden" :value="__('Nama Jenis Insiden')"/>
        <x-text-input id="nama_jenis_insiden" name="nama_jenis_insiden" type="text" class="mt-1 block w-full" :value="old('nama_jenis_insiden', $jenisInsiden?->nama_jenis_insiden)" autocomplete="nama_jenis_insiden" placeholder="Nama Jenis Insiden"/>
        
        <x-input-error class="mt-2" :messages="$errors->get('nama_jenis_insiden')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>