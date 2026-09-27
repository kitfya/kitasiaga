@props(['active'])

@php
$classes = ($active ?? false)
            ? 'px-3 py-2 text-xs font-semibold rounded-md bg-red-50 text-red-700 border border-red-200 transition-colors flex items-center gap-1.5'
            : 'px-3 py-2 text-xs font-medium text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 rounded-md transition-colors flex items-center gap-1.5';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
