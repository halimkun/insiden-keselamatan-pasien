<div class="space-y-6">
    
    <div>
        <x-input-label for="jenis_penanggung" :value="__('Jenis Penanggung')"/>
        <x-text-input id="jenis_penanggung" name="jenis_penanggung" type="text" class="mt-1 block w-full" :value="old('jenis_penanggung', $penanggungBiaya?->jenis_penanggung)" autocomplete="jenis_penanggung" placeholder="Jenis Penanggung"/>
        
        <x-input-error class="mt-2" :messages="$errors->get('jenis_penanggung')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>