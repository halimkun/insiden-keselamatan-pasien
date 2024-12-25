@props([
    'title',
    'riskGrading',           // Enum: Rendah, Moderat, Tinggi, Ekstrim
])

@php
    $alertClasses = [
        'Rendah'  => 'bg-sky-100 border-sky-300',
        'Moderat' => 'bg-emerald-100 border-emerald-300',
        'Tinggi'  => 'bg-amber-100 border-amber-300',
        'Ekstrim' => 'bg-rose-100 border-rose-300',
    ];
    
    $iconClasses = [
        'Rendah'  => 'bg-sky-50 border-sky-500 text-sky-500',
        'Moderat' => 'bg-emerald-50 border-emerald-500 text-emerald-500',
        'Tinggi'  => 'bg-amber-50 border-amber-500 text-amber-500',
        'Ekstrim' => 'bg-rose-50 border-rose-500 text-rose-500',
    ];

    $titleClasses = [
        'Rendah'  => 'text-sky-800',
        'Moderat' => 'text-emerald-800',
        'Tinggi'  => 'text-amber-800',
        'Ekstrim' => 'text-rose-800',
    ];

    $bodyClasses = [
        'Rendah'  => 'text-sky-600',
        'Moderat' => 'text-emerald-600',
        'Tinggi'  => 'text-amber-600',
        'Ekstrim' => 'text-rose-600',
    ];

    $alertClass = $alertClasses[$riskGrading] ?? $alertClasses['Rendah'];
    $iconColor = $iconClasses[$riskGrading] ?? $iconClasses['Rendah'];
    $titleColor = $titleClasses[$riskGrading] ?? $titleClasses['Rendah'];
    $bodyColor = $bodyClasses[$riskGrading] ?? $bodyClasses['Rendah'];
@endphp

<div class="alert flex flex-row items-center p-5 rounded {{ $alertClass }}">
    <div class="alert-icon flex items-center border {{ $iconColor }} justify-center h-10 w-10 flex-shrink-0 rounded-full">
        <span class="{{ explode(' ', $iconColor)[1] }}">
            <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </div>
    <div class="alert-content ml-4">
        <div class="alert-title font-semibold text-lg {{ $titleColor }}">
            {{ $title }}
        </div>
        <div class="alert-description text-sm {{ $bodyColor }}">
            {{ $slot }}
        </div>
    </div>
</div>