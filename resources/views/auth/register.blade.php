<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Buat Akun Baru</h2>
        <p class="mt-2 text-sm text-slate-600">Daftar untuk mulai menggunakan sistem</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" class="block mt-1.5 w-full" required
                autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" class="block mt-1.5 w-full"
                required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" class="block mt-1.5 w-full" required
                autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                class="block mt-1.5 w-full" required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center">
            Daftar
        </x-primary-button>

        {{-- Login Link --}}
        <p class="text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-rose-600 hover:text-rose-500">
                Masuk disini
            </a>
        </p>
    </form>
</x-guest-layout>