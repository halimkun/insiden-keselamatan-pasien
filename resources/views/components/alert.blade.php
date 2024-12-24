@props([
    'title',
    'type' => 'info' // Enum: success, error, warning, info
])

@php
    $alertClasses = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error'   => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info'    => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
    $class = $alertClasses[$type] ?? $alertClasses['info'];
@endphp

<div class="{{ $class }} border px-4 py-3 rounded-lg relative mb-5" role="alert">
    <strong class="font-bold alert-title">{{ $title }}</strong>
    <div class="alert-body">
        {{ $slot }}
    </div>
</div>
