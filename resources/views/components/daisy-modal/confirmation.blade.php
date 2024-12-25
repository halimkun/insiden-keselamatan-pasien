@props([
    'id',
    'title',
    'description' => '',
    'method' => 'POST',
    'actionUrl' => '#',
    'confirmText' => 'Confirm',
])

<dialog class="modal" id="{{ $id }}">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
          
        <form method="POST" action="{{ $actionUrl }}">
            @csrf

            @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
                @method($method)
            @endif

            <h3 class="text-lg font-bold title">{{ $title }}</h3>
            <p class="mt-1 text-sm description">{{ $description }}</p>

            <div class="modal-action mt-5 flex justify-end space-x-4">
                @if ($method == 'DELETE')
                    <x-danger-button type="submit">{{ $confirmText }}</x-danger-button>
                @else
                    <x-primary-button type="submit">{{ $confirmText }}</x-primary-button>
                @endif
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>