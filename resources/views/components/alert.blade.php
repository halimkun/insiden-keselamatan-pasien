@props([
    'title',
    'type' => 'info' // Enum: success, error, warning, info
])

@php
    $alertClasses = [
        'success' => 'bg-green-100 text-green-700',
        'error'   => 'bg-red-100 text-red-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'info'    => 'bg-blue-100 text-blue-700',
    ];
    $class = $alertClasses[$type] ?? $alertClasses['info'];
@endphp

<div class="{{ $class }} p-6 py-4 rounded-lg shadow-lg shadow-gray-400/15 relative mb-5" role="alert">
    <strong class="font-bold alert-title">{{ $title }}</strong>
    <div class="alert-body">
        {{ $slot }}
    </div>
</div>
