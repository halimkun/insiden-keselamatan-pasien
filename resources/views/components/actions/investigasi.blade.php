@canany(['lihat_investigasi', 'lihat_semua_investigasi'])
    <div class="flex gap-3 items-center">
        <a href="{{ route('insiden.investigasi.show', [$investigasi->insiden->id, $investigasi->id]) }}" class="btn btn-xs btn-square btn-success text-white" title="Lihat Investigasi">
            <x-icons.report class="w-[16px] h-[16px]" />
        </a>

        <a href="{{ route('insiden.investigasi.show', [$investigasi->insiden->id, $investigasi->id]) }}" class="hover:text-indigo-900">
            <x-icons.search class="h-[1.1rem] w-[1.1rem]" />
        </a>

        @canany(['edit_semua_investigasi', 'edit_investigasi'])
            @if ($investigasi->insiden->created_by == Auth::user()->id || Auth::user()->can('edit_semua_investigasi'))
                <a href="{{ route('insiden.investigasi.edit', [$investigasi->insiden->id, $investigasi->id]) }}" class="hover:text-indigo-900">
                    <x-icons.edit-circle class="h-[1.1rem] w-[1.1rem]" />
                </a>
            @endif
        @endcanany

        @canany(['hapus_investigasi', 'hapus_semua_investigasi'])
            @if ($investigasi->insiden->created_by == Auth::user()->id || Auth::user()->can('hapus_semua_investigasi'))
                <button class="text-red-600 hover:text-red-900 delete-investigasi" data-id="{{ $investigasi->id }}" data-label="{{ $investigasi->judul }}" data-insiden-id="{{ $investigasi->insiden->id }}">
                    <x-icons.trash class="h-[1.1rem] w-[1.1rem]" />
                </button>
            @endif
        @endcanany
    </div>
@endcanany