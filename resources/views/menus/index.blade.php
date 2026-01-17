@if(auth()->user()->role === 'admin')
    <x-admin-layout>
        <x-slot name="header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white fw-bold mb-0">
                    <i class="bi bi-menu-button-wide me-2"></i>{{ __('Daftar Menu') }}
                </h2>
                <a href="{{ route('admin.menus.create') }}" class="btn btn-light">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Menu
                </a>
            </div>
        </x-slot>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Add Menu Button -->
        <div class="mb-4 d-flex justify-content-end">
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Tambah Menu Baru
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.menus.index') }}" class="row g-3">
                    <div class="col-12 col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." 
                            class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="is_available" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_available') == '1' ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ request('is_available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                    </div>
                    @if(request('search') || request('category_id') || request('is_available') !== '')
                        <div class="col-12 col-md-2">
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i>Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Menus Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $menu)
                                <tr>
                                    <td>
                                        @if($menu->image)
                                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 80px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $menu->name }}</strong></td>
                                    <td><span class="badge bg-info">{{ $menu->category->name }}</span></td>
                                    <td class="fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                    <td>{{ $menu->stock }}</td>
                                    <td>
                                        @if($menu->is_available)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('admin.menus.toggle-availability', $menu) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-{{ $menu->is_available ? 'toggle-on' : 'toggle-off' }}"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.menus.show', $menu) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada menu ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer bg-white border-0">
                    {{ $menus->links() }}
                </div>
            </div>
        </div>
    </x-admin-layout>
@else
    <x-kasir-layout>
        <x-slot name="header">
            <h2 class="text-white fw-bold mb-0">
                <i class="bi bi-menu-button-wide me-2"></i>{{ __('Daftar Menu') }}
            </h2>
        </x-slot>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('menus.index') }}" class="row g-3">
                    <div class="col-12 col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." 
                            class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="is_available" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_available') == '1' ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ request('is_available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                    </div>
                    @if(request('search') || request('category_id') || request('is_available') !== '')
                        <div class="col-12 col-md-2">
                            <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i>Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Menus Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $menu)
                                <tr>
                                    <td>
                                        @if($menu->image)
                                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 80px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $menu->name }}</strong></td>
                                    <td><span class="badge bg-info">{{ $menu->category->name }}</span></td>
                                    <td class="fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                    <td>{{ $menu->stock }}</td>
                                    <td>
                                        @if($menu->is_available)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('menus.show', $menu) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye me-1"></i>Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada menu ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer bg-white border-0">
                    {{ $menus->links() }}
                </div>
            </div>
        </div>
    </x-kasir-layout>
@endif