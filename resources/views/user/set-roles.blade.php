<x-app-layout>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-gray-900">Set User Role & Permission</h2>
                    <p class="text-sm text-gray-600">Atur role dan permission untuk user <span class="font-bold">{{$user->name }}</span>.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a type="button" href="{{ route('users.index') }}"
                        class="flex gap-2 items-center rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        <x-icons.arrow-back class="h-5 w-5" />
                        Kembali
                    </a>
                </div>
            </header>
        </div>

        <div class="grid grid-cols-2 items-start gap-4 mt-6">
            <div class="mt-6 border rounded-xl p-6 bg-white shadow">
                <header class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h2 class="text-sm font-semibold text-gray-900">Anda dapat menambahkan lebih dari satu role untuk user ini.</h2>
                        <p class="mt-1 text-xs text-gray-600">Setiap role yang dipilih akan memberikan user akses ke permission yang terkait dengan role tersebut.</p>
                    </div>
                </header>

                <hr class="my-4">

                <x-alert title="Warning !" type="warning">
                    <p class="text-xs">Jika memilih role untuk user, maka <u>semua permission custom akan dihapus</u>, dan disesuaikan dengan permission yang terkait dengan role yang dipilih.</p>
                </x-alert>

                <form action="{{ route('users.set-roles', $user) }}" method="POST">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($roles->sortByDesc(fn($role) => $role->permissions->count()) as $role)
                        <div class="flex flex-col items-start p-3 border rounded">
                            <div class="flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }} class="checkbox checkbox-xs checked:checkbox-primary" id="role-{{$role->id }}">
                                <label class="ml-2 text-sm font-semibold text-gray-900 capitalize" for="role-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                            <div class="ml-8">
                                <ul class="list-disc list-inside">
                                    @foreach ($role->permissions as $permission)
                                    <li class="text-xs text-gray-600 capitalize">{{ \Str::replace('_', ' ', $permission->name) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @csrf
                    
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="rounded-md bg-primary px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Simpan Role
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-6 border rounded-xl p-6 bg-white shadow">
                <header class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h2 class="text-sm font-semibold text-gray-900">Anda juga dapat menambahkan permission secara langsung.</h2>
                        <p class="mt-1 text-xs text-gray-600">Permission yang dipilih akan memberikan user akses ke fitur yang terkait dengan permission tersebut, walau user tidak memiliki role yang terkait.</p>
                    </div>
                </header>

                <hr class="my-4">

                <x-alert title="Warning !" type="warning">
                    <p class="text-xs">Jika memilih permission untuk user, maka <u>semua role yang dipilih akan dihapus</u>, dan disesuaikan dengan permission yang dipilih.</p>
                </x-alert>

                <form action="{{ route('users.set-permissions', $user) }}" method="POST">
                    <div class="grid grid-cols-2 gap-2 lg:grid-cols-3">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center border rounded-lg px-3 py-2" for="permission-{{ $permission->id }}">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }} class="checkbox checkbox-xs checked:checkbox-primary" id="permission-{{$permission->id}}">
                                <label class="ml-2 text-xs capitalize" for="permission-{{ $permission->id }}">
                                    {{ \Str::replace('_', ' ', $permission->name) }}
                                </label>
                            </label>
                        @endforeach
                    </div>

                    @csrf
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="rounded-md bg-primary px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Simpan Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>