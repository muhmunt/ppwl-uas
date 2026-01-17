<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <x-ui.input type="password" name="current_password" label="Password Saat Ini" autocomplete="current-password"
        :error="$errors->updatePassword->first('current_password')" />

    <x-ui.input type="password" name="password" label="Password Baru" autocomplete="new-password"
        :error="$errors->updatePassword->first('password')" />

    <x-ui.input type="password" name="password_confirmation" label="Konfirmasi Password Baru"
        autocomplete="new-password" :error="$errors->updatePassword->first('password_confirmation')" />

    <div class="flex items-center gap-4">
        <x-ui.button type="submit" variant="primary">
            Update Password
        </x-ui.button>

        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-emerald-600">Tersimpan.</p>
        @endif
    </div>
</form>