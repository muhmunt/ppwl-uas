<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Lupa Password?</h2>
        <p class="mt-2 text-sm text-slate-600">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
        </p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" class="block mt-1.5 w-full"
                required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center">
            Kirim Link Reset Password
        </x-primary-button>

        {{-- Back to Login --}}
        <p class="text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="font-medium text-rose-600 hover:text-rose-500">
                ← Kembali ke halaman login
            </a>
        </p>
    </form>
</x-guest-layout>