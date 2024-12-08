@props([
    'text'   => 'Content',
    'color'  => 'text-gray-400',
    'border' => 'border-gray-400',
])

<div>
    <div class="relative flex items-center">
        <div class="flex-grow border-t border-dashed {{ $border }}"></div>
        <span class="flex-shrink mx-4 text-xs {{ $color }} uppercase">
            {{ $text }}
        </span>
        <div class="flex-grow border-t border-dashed {{ $border }}">
    </div>
</div>