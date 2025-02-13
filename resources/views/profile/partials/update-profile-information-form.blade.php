<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex w-full gap-3">
            <div class="w-full">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :disabled="!($isCreate ?? false)" :value="old('username', $user->username)" required autofocus autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div class="w-full">
                <x-input-label for="no_hp" value="Nomor HP" />
                <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user?->detail?->no_hp)" autocomplete="no_hp" placeholder="nomor hp" />
                <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
            </div>

            <div class="w-full">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="mt-2 text-sm text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex w-full flex-col items-start justify-start gap-6 lg:flex-row">
            <div class="w-full">
                <x-input-label for="jabatan" value="Jabatan" />
                <x-text-input disabled id="jabatan" name="jabatan" type="text" class="mt-1 block w-full bg-gray-100" :value="old('jabatan', $user?->detail?->jabatan->nama)" autocomplete="jabatan" placeholder="jabatan" />
                <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
            </div>

            <div class="w-full">
                <x-input-label for="unit" value="Unit" />
                <x-text-input disabled id="unit" name="unit" type="text" class="mt-1 block w-full bg-gray-100" :value="old('unit', $user?->detail?->unit->nama_unit)" autocomplete="unit" placeholder="unit" />
                <x-input-error class="mt-2" :messages="$errors->get('unit')" />
            </div>

            <div class="w-full">
                <x-input-label for="departemen" :value="__('departemen')" />
                <x-text-input disabled id="departemen" name="departemen" type="text" class="mt-1 block w-full bg-gray-100" :value="old('departemen', $user?->detail?->departemen)" autocomplete="departemen" placeholder="departemen" />
                <x-input-error class="mt-2" :messages="$errors->get('departemen')" />
            </div>
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
