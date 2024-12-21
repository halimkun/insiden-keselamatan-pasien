@props([
    'id',
    'title',
    'description' => 'Please enter your password to set a new password.',
    'actionUrl' => '#',
])

<dialog class="modal" id="{{ $id }}">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
          
        <form method="POST" action="{{ $actionUrl }}">
            @csrf
            @method('PATCH')

            <h3 class="text-lg font-bold title">{{ $title }}</h3>
            <p class="mt-1 text-sm description">{{ $description }}</p>

            {{-- input with label --}}
            <div class="mt-5">
                <div class="space-y-1 ">
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="input w-full h-10" type="password" name="password" required />
                </div>

                <div class="space-y-1 mt-4">
                    <x-input-label for="password_confirmation" value="Confirm Password" />
                    <x-text-input id="password_confirmation" class="input w-full h-10" type="password" name="password_confirmation" required />
                </div>
            </div>

            <div class="modal-action mt-5 flex justify-end space-x-4">
                <x-primary-button type="submit">Set Password</x-primary-button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>