<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-full rounded-r-lg lg:rounded-lg w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0 shadow"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5">
        @if (\App\Helpers\SettingHelper::get('site_logo'))
        <img src="{{ asset("images/" . \App\Helpers\SettingHelper::get('site_logo', 'logo.png' )) }}" alt="Logo"
            class="w-[140px]" />
        @else
        <div class="text-xl font-bold leading-none text-white">
            {{ \App\Helpers\SettingHelper::get('site_name', 'Site Name') }}
        </div>
        @endif

        <button class="block lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill="" />
            </svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="px-4 py-4 lg:px-6">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">APP MENU</h3>

                <ul class="mb-6 flex flex-col gap-1.5">

                    <!-- Menu Item Dashboard -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('dashboard') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('dashboard') }}">
                            <x-icons.dashboard class="h-5 w-5" />

                            Dashboard
                        </a>
                    </li>
                    <!-- Menu Item Dashboard -->

                    @canany(['lihat_insiden', 'lihat_insiden_pribadi', 'lihat_unit_insiden', 'lihat_semua_insiden'])
                    <!-- Menu Item Insiden -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('insiden.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('insiden.index') }}">
                            <x-icons.alert-triangle class="h-5 w-5" />

                            Insiden
                        </a>
                    </li>
                    <!-- Menu Item Insiden -->
                    @endcanany

                    <!-- Menu Item Investigasi -->
                    {{-- <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('investigasi.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('investigasi.index') }}">
                            <x-icons.report-search class="h-5 w-5" />

                            Investigasi Sederhana
                        </a>
                    </li> --}}
                    <!-- Menu Item Investigasi -->
                </ul>
            </div>

            @canany(['lihat_pasien', 'lihat_karyawan', 'lihat_unit', 'lihat_jenis_insiden', 'lihat_penanggung_biaya'])
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MASTER DATA</h3>

                <ul class="mb-6 flex flex-col gap-1.5">
                    @can('lihat_pasien')
                    <!-- Menu Item Pasien -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('pasien.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('pasien.index') }}">
                            <x-icons.health-recognition class="h-5 w-5" />

                            Pasien
                        </a>
                    </li>
                    <!-- Menu Item Pasien -->
                    @endcan

                    @can('lihat_karyawan')
                    <!-- Menu Item Karyawan -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('users.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('users.index') }}">
                            <x-icons.users class="h-5 w-5" />

                            Karyawan
                        </a>
                    </li>
                    <!-- Menu Item Karyawan -->
                    @endcan

                    @can('lihat_unit')
                    <!-- Menu Item Unit -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('unit.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('unit.index') }}">
                            <x-icons.sign-right class="h-6 w-6" />

                            Unit
                        </a>
                    </li>
                    <!-- Menu Item Unit -->
                    @endcan

                    @can('lihat_jenis_insiden')
                    <!-- Menu Item Jenis Insiden -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('jenis-insiden.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('jenis-insiden.index') }}">
                            <x-icons.category-2 class="h-5.5 w-5.5" />

                            Jenis Insiden
                        </a>
                    </li>
                    <!-- Menu Item Jenis Insiden -->
                    @endcan

                    @can('lihat_penanggung_biaya')
                    <!-- Menu Item Penanggung Biaya -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('penanggung-biaya.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('penanggung-biaya.index') }}">
                            <x-icons.pig-money class="h-5 w-5" />

                            Penanggung Biaya
                        </a>
                    </li>
                    <!-- Menu Item Penanggung Biaya -->
                    @endcan
                </ul>
            </div>
            @endcanany

            {{-- only admin --}}
            @if (auth()->user()->isAdmin())
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">ROLES & PERMISSION</h3>
                <ul class="mb-6 flex flex-col gap-1.5">
                    {{-- manage menu --}}
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('roles.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('roles.index') }}">
                            <x-icons.shield class="h-5 w-5" />

                            Roles & Permission
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">SETTINGS</h3>
                <ul class="mb-6 flex flex-col gap-1.5">
                    {{-- manage menu --}}
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{ request()->routeIs('settings.index') ? 'bg-graydark dark:bg-meta-4' : '' }}"
                            href="{{ route('settings.index') }}">
                            <x-icons.settings class="h-5 w-5" />

                            Site Settings
                        </a>
                    </li>
                </ul>
            </div>
            @endif

        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>