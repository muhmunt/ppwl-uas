<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Selamat Datang</h2>
        <p class="mt-2 text-sm text-slate-600">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" class="block mt-1.5 w-full"
                required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-rose-600 hover:text-rose-500" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" class="block mt-1.5 w-full" required
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center">
            <input id="remember_me" type="checkbox"
                class="w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-slate-600">
                Ingat saya
            </label>
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center">
            Masuk
        </x-primary-button>

        {{-- Register Link --}}
        @if (Route::has('register'))
            <p class="text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-rose-600 hover:text-rose-500">
                    Daftar sekarang
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>