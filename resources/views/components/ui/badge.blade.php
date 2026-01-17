@props([
    'type' => 'neutral',
])
@php
    $typeClasses = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        'neutral' => 'badge-neutral',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . ($typeClasses[$type] ?? $typeClasses['neutral'])]) }}>
    {{ $slot }}
</span>
