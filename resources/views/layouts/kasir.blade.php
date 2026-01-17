{{-- Kasir Layout - extends the unified app layout --}}
<x-app-layout>
    @isset($header)
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endisset

    {{ $slot }}
</x-app-layout>