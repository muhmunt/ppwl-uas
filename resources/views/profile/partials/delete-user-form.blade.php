<div class="space-y-4">
    <p class="text-sm text-slate-600">
        Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Pastikan Anda telah mengunduh data yang
        ingin disimpan.
    </p>

    <x-ui.button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        Hapus Akun
    </x-ui.button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-slate-900">
                Apakah Anda yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-sm text-slate-600">
                Semua data akan dihapus secara permanen. Masukkan password untuk mengkonfirmasi.
            </p>

            <div class="mt-6">
                <x-ui.input type="password" name="password" placeholder="Password"
                    :error="$errors->userDeletion->first('password')" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-ui.button variant="ghost" x-on:click="$dispatch('close')">
                    Batal
                </x-ui.button>
                <x-ui.button type="submit" variant="danger">
                    Hapus Akun
                </x-ui.button>
            </div>
        </form>
    </x-modal>
</div>