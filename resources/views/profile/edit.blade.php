<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Pengguna
        </h2>
    </x-slot>

    <div>
        <div class="space-y-6 sm:space-y-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @can('hapus_profil')
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>