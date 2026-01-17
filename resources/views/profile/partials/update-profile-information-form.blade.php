<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <x-ui.input name="name" label="Nama" :value="old('name', $user->name)" required autofocus
        :error="$errors->first('name')" />

    <div>
        <x-ui.input type="email" name="email" label="Email" :value="old('email', $user->email)" required
            :error="$errors->first('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-sm text-slate-600">
                    Email Anda belum terverifikasi.
                <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-rose-600 hover:text-rose-500 font-medium">
                        Kirim ulang email verifikasi
                    </button>
                </form>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-emerald-600">
                        Link verifikasi baru telah dikirim ke email Anda.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="flex items-center gap-4">
        <x-ui.button type="submit" variant="primary">
            Simpan
        </x-ui.button>

        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-emerald-600">Tersimpan.</p>
        @endif
    </div>
</form>