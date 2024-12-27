<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-center justify-between gap-6 md:flex-row md:gap-0">
            <h2 class="flex items-center gap-2 text-xl font-semibold leading-none text-gray-800">
                <x-icons.shield class="h-6 w-6" />
                Role & Permission
            </h2>
        </div>
    </x-slot>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-gray-900">Role & Permission</h2>
                    <p class="mt-1 text-sm text-gray-600">Update Permission of Role.</p>
                </div>
            </header>

            <div class="flow-root">
                <div class="mt-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <form action="{{ route('roles.store') }}" method="POST" class="w-full overflow-x-auto">
                            @csrf
                            <table class="w-full table-role">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-sm font-semibold uppercase tracking-wide text-gray-500 bg-gray-100 dark:bg-gray-800">Permission</th>
                                        @foreach ($roles as $role)
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-sm font-semibold uppercase tracking-wide text-gray-500">
                                            {{ $role->name }}
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                    <tr>
                                        <td class="py-3 pl-4 pr-3 text-left text-xs font-semibold capitalize tracking-wide text-gray-500 bg-gray-100 dark:bg-gray-800">
                                            {{ \Str::replace('_', ' ', $permission->name) }}
                                        </td>
                                        @foreach ($roles as $role)
                                        <td class="py-3 pl-4 pr-3 text-left text-xs font-semibold capitalize tracking-wide text-gray-500">
                                            <input 
                                                type="checkbox" 
                                                name="{{ $role->name }}[]"
                                                value="{{ $permission->name }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}
                                            >
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-6">
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <x-icons.check class="h-5 w-5" />
                                        Update Permission
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('static/js/dataTables.js') }}"></script>
        <script src="{{ asset('static/js/dataTables.tailwindcss.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.table-role').DataTable({
                    // disable paging, select page lenth and search
                    paging: false,
                    lengthChange: false,
                })
            })
        </script>
    @endpush
</x-app-layout>