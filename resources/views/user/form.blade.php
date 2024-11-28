<div class="space-y-6">

    <div>
        <x-input-label for="name" value="Nama" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user?->name)" autocomplete="name" placeholder="Nama" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="flex w-full flex-col items-start justify-start gap-6 lg:flex-row">
        <div class="w-full">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full {{ !($isCreate ?? false) ? 'bg-gray-100' : '' }}" :readonly="!($isCreate ?? false)" :value="old('username', $user?->username)" autocomplete="username" placeholder="Username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div class="w-full">
            <x-input-label for="no_hp" value="Nomor HP" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user?->detail?->no_hp)" autocomplete="no_hp" placeholder="nomor hp" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>

        <div class="w-full">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user?->email)" autocomplete="email" placeholder="Email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
    </div>

    <div class="flex w-full flex-col items-start justify-start gap-6 lg:flex-row">
        <div class="w-full">
            <x-input-label for="jabatan" value="Jabatan" />
            <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full" :value="old('jabatan', $user?->detail?->jabatan)" autocomplete="jabatan" placeholder="jabatan" />
            <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
        </div>

        <div class="w-full">
            <x-input-label for="unit" value="Unit" />
            <select id="unit" name="unit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- Pilih Unit --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit', $user?->detail?->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
        </div>

        <div class="w-full">
            <x-input-label for="departemen" :value="__('departemen')" />
            <x-text-input id="departemen" name="departemen" type="text" class="mt-1 block w-full" :value="old('departemen', $user?->detail?->departemen)" autocomplete="departemen" placeholder="departemen" />
            <x-input-error class="mt-2" :messages="$errors->get('departemen')" />
        </div>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
