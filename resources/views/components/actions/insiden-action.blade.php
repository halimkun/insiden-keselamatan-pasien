<div class="flex items-center justify-center gap-3">
    <a href="{{ $showUrl }}" class="text-gray-600 hover:text-indigo-600" title="Lihat detail">
        <x-icons.search class="h-[1rem] w-[1rem]" />
    </a>

    @if (!Auth::user()->can('grading_insiden') || !Auth::user()->can('hapus_insiden'))
        <a href="{{ $showUrl }}" class="text-gray-600 hover:text-indigo-600" title="Lihat detail">
            <x-icons.print class="h-[1rem] w-[1rem]" />
        </a>
    @endif

    @can('edit_insiden')
        @if ($insiden->created_by == Auth::id() || (Auth::user()->can('edit_unit_insiden') && Auth::user()->detail?->unit_id == $insiden->unit_id) || Auth::user()->can('edit_semua_insiden'))
            <a href="{{ $editUrl }}" class="text-gray-600 hover:text-indigo-600" title="Edit data">
                <x-icons.edit class="h-[1rem] w-[1rem]" />
            </a>
        @endif
    @endcan

    @canany(['grading_insiden', 'hapus_insiden'])
        <div class="dropdown dropdown-left">
            <div tabindex="0" role="button" class="inline-flex items-center rounded-lg border px-1 py-1 text-center transition duration-150 ease-in-out hover:bg-indigo-600 hover:text-white">
                <div>
                    <x-icons.dots-vertical class="h-[0.9rem] w-[0.9rem]" />
                </div>
            </div>
            <div tabindex="0" class="menu dropdown-content z-10 w-52 rounded-box border bg-base-100 p-2 shadow">
                <ul>
                    <li>
                        <a href="{{ $printUrl }}" class="text-gray-600 hover:text-indigo-600">
                            <x-icons.print class="h-[1rem] w-[1rem]" />
                            Cetak Insiden
                        </a>
                    </li>

                    @can('grading_insiden')
                        @if ($insiden->grading)
                            @can('edit_insiden')
                                <li>
                                    <a href="{{ $editUrl }}#grading-insiden" class="text-gray-600 hover:text-indigo-600">
                                        <x-icons.label-filled class="h-[1rem] w-[1rem]" />
                                        Ubah Grading
                                    </a>
                                </li>
                            @elsecan('lihat_insiden')
                                <li>
                                    <a href="{{ $showUrl }}#grading-insiden" class="text-gray-600 hover:text-indigo-600">
                                        <x-icons.label-filled class="h-[1rem] w-[1rem]" />
                                        Lihat Grading
                                    </a>
                                </li>
                            @endcan
                        @else
                            <li>
                                <a href="{{ $showUrl }}#grading-insiden" class="text-gray-600 hover:text-indigo-600">
                                    <x-icons.label class="h-[1rem] w-[1rem]" />
                                    Grading Insiden
                                </a>
                            </li>
                        @endif
                    @endcan

                    {{-- @canany(['lihat_investigasi', 'lihat_semua_investigasi'])
                        @if ($insiden->investigasi)
                            <li>
                                <a href="{{ route('insiden.investigasi.show', [$insiden->id, $insiden->investigasi->id]) }}" class="text-gray-600 hover:text-indigo-600">
                                    <x-icons.report class="h-[1rem] w-[1rem]" />
                                    Lihat Investigasi
                                </a>
                            </li>
                        @else
                            @can('tambah_investigasi')
                                <li>
                                    <a href="{{ route('insiden.investigasi.create', $insiden->id) }}" class="text-gray-600 hover:text-indigo-600">
                                        <x-icons.report-search class="h-[1rem] w-[1rem]" />
                                        Buat Investigasi
                                    </a>
                                </li>
                            @endcan
                        @endif
                    @endcanany --}}

                    @can('hapus_insiden')
                        @if ($insiden->created_by == Auth::id() || (Auth::user()->can('hapus_unit_insiden') && Auth::user()->detail?->unit_id == $insiden->unit_id) || Auth::user()->can('hapus_semua_insiden'))
                            @if($insiden->deleted_at)
                                <li>
                                    <button class="text-green-600 hover:text-green-900 restore-insiden" data-id="{{ $insiden->id }}" data-insiden="{{ $insiden->insiden }}">
                                        <x-icons.restore class="h-[1rem] w-[1rem]" />
                                        Restore
                                    </button>
                                </li>
                            @else
                                <li>
                                    <button class="text-red-600 hover:text-red-900 delete-insiden" data-id="{{ $insiden->id }}" data-insiden="{{ $insiden->insiden }}">
                                        <x-icons.trash class="h-[1rem] w-[1rem]" />
                                        Delete
                                    </button>
                                </li>
                            @endif
                        @else
                            <li>
                                <div class="text-gray-600 hover:text-gray-900 delete-insiden">
                                    Tidak ada aksi lain untuk insiden ini
                                </div>
                            </li>
                        @endif
                    @endcan
                </ul>
            </div>
        </div>  
    @endcanany
</div>