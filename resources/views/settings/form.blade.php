<div class="space-y-6">
    <div class="flex gap-4">
        <div class="w-full">
            <x-input-label for="site_name" :value="__('Nama Website')" />
            <x-text-input id="site_name" name="site_name" type="text" class="mt-1 block w-full" :value="old('site_name', \App\Helpers\SettingHelper::get('site_name'))" autocomplete="site_name" placeholder="Nama Website" />
    
            <x-input-error class="mt-2" :messages="$errors->get('site_name')" />
        </div>
    
        <div class="w-full">
            <x-input-label for="faskes_name" :value="__('Nama Faskes')" />
            <x-text-input id="faskes_name" name="faskes_name" type="text" class="mt-1 block w-full" :value="old('faskes_name', \App\Helpers\SettingHelper::get('faskes_name'))" autocomplete="faskes_name" placeholder="Nama Faskes" />
    
            <x-input-error class="mt-2" :messages="$errors->get('faskes_name')" />
        </div>
    </div>

    {{-- site description and faskes address in text area flex --}}
    <div class="flex gap-4">
        <div class="w-full">
            <x-input-label for="site_description" :value="__('Deskripsi Website')" />
            <textarea 
                id="site_description" 
                name="site_description" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                autocomplete="site_description" 
                placeholder="Deskripsi Website"
            >{{ old('site_description', \App\Helpers\SettingHelper::get('site_description')) }}</textarea>
    
            <x-input-error class="mt-2" :messages="$errors->get('site_description')" />
        </div>
    
        <div class="w-full">
            <x-input-label for="faskes_address" :value="__('Alamat Faskes')" />
            <textarea 
                id="faskes_address" 
                name="faskes_address" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                autocomplete="faskes_address" 
                placeholder="Alamat Faskes"
            >{{ old('faskes_address', \App\Helpers\SettingHelper::get('faskes_address')) }}</textarea>
    
            <x-input-error class="mt-2" :messages="$errors->get('faskes_address')" />
        </div>
    </div>

    {{-- site logo with preview --}}
    <div class="flex items-stretch gap-4 max-w-xl">
        @if (\App\Helpers\SettingHelper::get('site_logo'))
            <div class="border rounded-xl shadow flex items-center justify-center px-3">
                <img src="{{ asset(\App\Helpers\SettingHelper::get('site_logo')) }}" alt="site logo" class="w-32 object-cover rounded-md shadow-sm">
            </div>
        @endif

        <div class="w-full max-w-xl">
            <x-input-label for="site_logo" :value="__('Logo Website')" />
            <input type="file" id="site_logo" name="site_logo" class="px-2 py-1.5 mt-1 block border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />

            
            <x-input-error class="mt-2" :messages="$errors->get('site_logo')" />
            <p class="mt-2 text-xs text-gray-500">Max. 2MB</p>
            <p class="text-xs text-gray-500">File type: jpg, jpeg, png</p>
        </div>
    </div>

    {{-- submit button --}}
    <div class="flex justify-end">
        <x-primary-button type="submit">Update</x-primary-button>
    </div>
</div>