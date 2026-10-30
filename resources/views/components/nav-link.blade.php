@props(['active'])

@php
$classes = ($active ?? false)
            ? 'px-3 py-2.5 text-sm font-semibold rounded-lg bg-red-50 text-red-700 border border-red-100 transition-colors flex items-center gap-2'
            : 'px-3 py-2.5 text-sm font-medium text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 rounded-lg transition-colors flex items-center gap-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
