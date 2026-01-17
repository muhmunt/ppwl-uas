<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Konfirmasi Password</h2>
        <p class="mt-2 text-sm text-slate-600">
            Ini adalah area yang dilindungi. Silakan konfirmasi password Anda untuk melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" class="block mt-1.5 w-full" required
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center">
            Konfirmasi
        </x-primary-button>
    </form>
</x-guest-layout>