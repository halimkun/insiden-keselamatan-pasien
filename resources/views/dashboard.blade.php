<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-boxdark overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-bodydark1">
            {{ __("You're logged in!") }}
        </div>
    </div>
</x-app-layout>