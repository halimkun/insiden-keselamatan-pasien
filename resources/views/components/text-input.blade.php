@props([
    'disabled' => false,
    'readonly' => false,
])

<input 
    @disabled($disabled) 
    @readonly($readonly) 
    {{ $attributes->merge(['class' => collect([
        'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
        ($disabled || $readonly) ? 'bg-gray-100' : ''
    ])->filter()->implode(' ')]) }} 
/>
