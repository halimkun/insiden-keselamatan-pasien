<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between">
            <h2 class="flex items-center gap-2 text-xl font-semibold leading-none text-gray-800">
                <x-icons.database class="h-5 w-5" />
                Master Data {{ request()->segment(2) ? "- " . \Str::headline(\Str::replace('-', " ", request()->segment(2))) : "" }}
            </h2>

            <x-master-data.navigation-boxed />
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-indigo-500 shadow-lg shadow-indigo-400 rounded-xl">
                <div class="flex flex-col-reverse md:flex-row items-start md:items-center md:justify-between gap-6 p-6">
                    <div class="text-white">
                        {{-- Master Data Title --}}
                        <h1 class="text-2xl font-semibold text-white">Master Data</h1>

                        {{-- subtitle with short description about master data --}}
                        <p class="text-sm text-white">Portal awal untuk mengelola master data berikut:</p>
                        
                        <div class="mt-5 hidden md:block">
                            <x-master-data.navigation-boxed />
                        </div>
                    </div>

                    <div class="p-10 bg-indigo-50 flex items-center justify-center rounded-xl hover:bg-indigo-100 transition-all duration-300 ease-in-out group">
                        <x-icons.database-star class="h-[2rem] w-[2rem] text-amber-500 group-hover:scale-110 transition-all duration-300 ease-in-out" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
