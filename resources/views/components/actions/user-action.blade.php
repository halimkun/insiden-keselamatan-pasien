<div class="flex items-center justify-center gap-3">
    <a href="{{ $showUrl }}" class="text-gray-600 hover:text-indigo-600" title="Lihat detail">
        <x-icons.user-search class="h-[1rem] w-[1rem]" />
    </a>

    @can('edit_karyawan')
        <a href="{{ $editUrl }}" class="text-gray-600 hover:text-indigo-600" title="Edit data">
            <x-icons.user-edit class="h-[1rem] w-[1rem]" />
        </a>
    @endcan

    <div class="dropdown dropdown-left">
        <div tabindex="0" role="button" class="inline-flex items-center rounded-lg border px-1 py-1 text-center transition duration-150 ease-in-out hover:bg-indigo-600 hover:text-white">
            <div>
                <x-icons.dots-vertical class="h-[0.9rem] w-[0.9rem]" />
            </div>
        </div>
        <div tabindex="0" class="menu dropdown-content z-10 w-52 rounded-box border bg-base-100 p-2 shadow">
            <ul>
                @can('ubah_password_karyawan')
                    <li>
                        <button class="text-gray-600 hover:text-indigo-600 set-password" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                            <x-icons.user-shild class="h-[1rem] w-[1rem]" />
                            Set Password
                        </button>
                    </li>
                @endcan
                
                @can('set_permission_karyawan')
                    <li>
                        <a href="{{ route('users.roles', $user->id) }}" class="text-gray-600 hover:text-indigo-600">
                            <x-icons.user-shild class="h-[1rem] w-[1rem]" />
                            Role & Permission
                        </a>
                    </li>
                @endcan

                @can('hapus_karyawan')
                    @if($user->deleted_at)
                        <li>
                            <button class="text-green-600 hover:text-green-900 restore-user" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                <x-icons.restore class="h-[1rem] w-[1rem]" />
                                Restore
                            </button>
                        </li>
                    @else
                        <li>
                            <button class="text-red-600 hover:text-red-900 delete-user" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                <x-icons.trash class="h-[1rem] w-[1rem]" />
                                Delete
                            </button>
                        </li>
                    @endif
                @endcan
            </ul>
        </div>
    </div>
</div>