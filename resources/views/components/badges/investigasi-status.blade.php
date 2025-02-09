<div class="flex flex-col gap-1.5 items-start">
    @if ($investigasi->lengkap)
        <div class="px-1 py-0.5 pr-2 text-xs font-semibold text-green-800 bg-green-200 rounded-full flex gap-0.5 items-center justify-center">
            <x-icons.circle-check class="h-[15px] w-[15px]" />
            Lengkap
        </div>
    @else
        <div class="px-1 py-0.5 pr-2 text-xs font-semibold text-red-800 bg-red-200 rounded-full flex gap-0.5 items-center justify-center">
            <x-icons.circle-x class="h-[15px] w-[15px]" />
            Belum Lengkap
        </div>
    @endif
    
    @if ($investigasi->lanjutan)
        <div class="px-1 py-0.5 pr-2 text-xs font-semibold text-green-800 bg-green-200 rounded-full flex gap-0.5 items-center justify-center">
            <x-icons.circle-check class="h-[15px] w-[15px]" />
            Investigasi Lanjutan
        </div>
    @else
        <div class="px-1 py-0.5 pr-2 text-xs font-semibold text-red-800 bg-red-200 rounded-full flex gap-0.5 items-center justify-center">
            <x-icons.circle-x class="h-[15px] w-[15px]" />
            Investigasi Lanjutan
        </div>
    @endif
</div>