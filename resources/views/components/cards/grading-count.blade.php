@props([
    'title',
    'subtitle',
    'count',
    'key',
])

@php
    $colors = [
        'biru'   => 'bg-sky-300',
        'hijau'  => 'bg-emerald-300',
        'kuning' => 'bg-amber-300',
        'merah'  => 'bg-rose-300',
    ];

    $countColor = [
        'biru'   => 'bg-sky-100 text-sky-600 border-2 border-white',
        'hijau'  => 'bg-emerald-100 text-emerald-600 border-2 border-white',
        'kuning' => 'bg-amber-100 text-amber-600 border-2 border-white',
        'merah'  => 'bg-rose-100 text-rose-600 border-2 border-white',
    ];

    $titleColor = [
        'biru'   => 'text-sky-900',
        'hijau'  => 'text-emerald-900',
        'kuning' => 'text-amber-900',
        'merah'  => 'text-rose-900',
    ];

    $subtitleColor = [
        'biru'   => 'text-sky-800',
        'hijau'  => 'text-emerald-800',
        'kuning' => 'text-amber-800',
        'merah'  => 'text-rose-800',
    ];
@endphp

<div class="{{ $colors[$key] ?? 'bg-gray-300' }} overflow-hidden shadow-lg shadow-gray-300/25 sm:rounded-2xl grading-item">
    <div class="p-6 text-gray-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="{{ $titleColor[$key] ?? 'text-gray-800' }} font-semibold capitalize">{{ $title }}</p>
                <p class="{{ $subtitleColor[$key] ?? 'text-gray-800' }} text-xs font-medium">{{ ucfirst(strtolower($subtitle)) }}</p>
            </div>

            <div class="flex items-center justify-center w-12 h-12 rounded-full {{ $countColor[$key] ?? 'bg-gray-100 text-gray-600 border-2 border-white' }}">
                <p class="text-2xl font-semibold">{{ $count }}</p>
            </div>
        </div>
    </div>
</div>