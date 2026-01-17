<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Verifikasi Email</h2>
        <p class="mt-2 text-sm text-slate-600">
            Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link
            yang telah kami kirim.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">
            Link verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center">
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm font-medium text-rose-600 hover:text-rose-500">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>