@props([
    'showUrl',
    'editUrl',

    'permission_edit',
    'permission_delete',

    'data',
    'attributeData' => []
])

<div class="flex items-center justify-center gap-3">
    <a href="{{ $showUrl }}" class="hover:text-indigo-900">
        <x-icons.search class="h-[1.1rem] w-[1.1rem]" />
    </a>

    @can($permission_edit)
    <a href="{{ $editUrl }}" class="hover:text-indigo-900">
        <x-icons.edit-circle class="h-[1.1rem] w-[1.1rem]" />
    </a>
    @endcan

    @can($permission_delete)
        @if ($data?->deleted_at)
            <button class="text-green-600 hover:text-green-900 restore-button"
                @foreach ($attributeData as $key => $value)
                    data-{{ $key }}="{{ $value }}"
                @endforeach
            >

                <x-icons.restore class="h-[1.1rem] w-[1.1rem]" />
            </button> 
        @endif

        @if (!$data?->deleted_at)
            <button class="text-red-600 hover:text-red-900 delete-button"
                @foreach ($attributeData as $key => $value)
                    data-{{ $key }}="{{ $value }}"
                @endforeach
            >
                <x-icons.trash class="h-[1.1rem] w-[1.1rem]" />
            </button>
        @endif
    @endcan
</div>