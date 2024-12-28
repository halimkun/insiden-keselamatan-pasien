<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-center justify-between gap-6 md:flex-row md:gap-0">
            <h2 class="flex items-center gap-2 text-xl font-semibold leading-none text-gray-800">
                <x-icons.settings class="h-6 w-6" />
                Site Setting
            </h2>
        </div>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-gray-900">Site Setting</h2>
                    <p class="mt-1 text-sm text-gray-600">Update site setting.</p>
                </div>
            </header>

            <div class="flow-root">
                <div class="mt-8">
                    <div class="py-2 align-middle">
                        <form method="POST" action="{{ route('settings.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('settings.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>