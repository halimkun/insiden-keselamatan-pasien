@canany(['lihat_investigasi', 'lihat_semua_investigasi'])
    <div class="flex gap-3 items-center">
        @if ($insiden->investigasi)
            <a href="{{ route('insiden.investigasi.show', [$insiden->id, $insiden->investigasi->id]) }}" class="btn btn-xs btn-square btn-success text-white" title="Lihat Investigasi">
                <x-icons.report class="w-[16px] h-[16px]" />
            </a>
        @else
            @can('tambah_investigasi')
                <a href="{{ route('insiden.investigasi.create', [$insiden->id]) }}" class="btn btn-xs btn-outline btn-square btn-success" title="Buat Investigasi">
                    <x-icons.report-search class="w-[16px] h-[16px]" />
                </a>
            @endcan
        @endif
    </div>
@endcanany