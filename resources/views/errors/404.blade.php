<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center">
        <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
        <p class="text-xl text-gray-600 mb-8">Halaman tidak ditemukan</p>
        <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Kembali ke Dashboard
        </a>
    </div>
</x-guest-layout>