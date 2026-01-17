<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Profil</h1>
                <p class="page-subtitle">Kelola informasi akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Update Profile Information --}}
        <x-ui.card>
            <x-slot name="header">
                <h3 class="font-semibold text-slate-900">Informasi Profil</h3>
                <p class="text-sm text-slate-500 mt-1">Update informasi profil dan email Anda.</p>
            </x-slot>

            @include('profile.partials.update-profile-information-form')
        </x-ui.card>

        {{-- Update Password --}}
        <x-ui.card>
            <x-slot name="header">
                <h3 class="font-semibold text-slate-900">Update Password</h3>
                <p class="text-sm text-slate-500 mt-1">Pastikan akun Anda menggunakan password yang kuat.</p>
            </x-slot>

            @include('profile.partials.update-password-form')
        </x-ui.card>

        {{-- Delete Account --}}
        <x-ui.card>
            <x-slot name="header">
                <h3 class="font-semibold text-red-600">Hapus Akun</h3>
                <p class="text-sm text-slate-500 mt-1">Hapus akun Anda secara permanen.</p>
            </x-slot>

            @include('profile.partials.delete-user-form')
        </x-ui.card>
    </div>
</x-app-layout>