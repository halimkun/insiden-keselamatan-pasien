<div class="space-y-6">
    
    <div>
        <x-input-label for="nama_unit" :value="__('Nama Unit')"/>
        <x-text-input id="nama_unit" name="nama_unit" type="text" class="mt-1 block w-full" :value="old('nama_unit', $unit?->nama_unit)" autocomplete="nama_unit" placeholder="Nama Unit"/>
        
        <x-input-error class="mt-2" :messages="$errors->get('nama_unit')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>