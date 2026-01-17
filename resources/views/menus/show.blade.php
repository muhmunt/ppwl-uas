@if(auth()->user()->role === 'admin')
    <x-admin-layout>
        <x-slot name="header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white fw-bold mb-0">
                    <i class="bi bi-eye me-2"></i>{{ __('Detail Menu') }}
                </h2>
                <div>
                    <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </a>
                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </form>
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Image -->
                            <div class="col-12 col-md-5">
                                @if($menu->image)
                                    <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="col-12 col-md-7">
                                <h3 class="fw-bold mb-4">{{ $menu->name }}</h3>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Kategori</label>
                                    <p class="mb-0"><span class="badge bg-info">{{ $menu->category->name }}</span></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Harga</label>
                                    <p class="mb-0 fs-4 fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Stok</label>
                                    <p class="mb-0 fs-5">{{ $menu->stock }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Status</label>
                                    <p class="mb-0">
                                        @if($menu->is_available)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                        @endif
                                    </p>
                                </div>

                                @if($menu->description)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted small">Deskripsi</label>
                                        <p class="mb-0">{{ $menu->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-admin-layout>
@else
    <x-kasir-layout>
        <x-slot name="header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white fw-bold mb-0">
                    <i class="bi bi-eye me-2"></i>{{ __('Detail Menu') }}
                </h2>
                <a href="{{ route('menus.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </x-slot>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Image -->
                            <div class="col-12 col-md-5">
                                @if($menu->image)
                                    <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="col-12 col-md-7">
                                <h3 class="fw-bold mb-4">{{ $menu->name }}</h3>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Kategori</label>
                                    <p class="mb-0"><span class="badge bg-info">{{ $menu->category->name }}</span></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Harga</label>
                                    <p class="mb-0 fs-4 fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Stok</label>
                                    <p class="mb-0 fs-5">{{ $menu->stock }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">Status</label>
                                    <p class="mb-0">
                                        @if($menu->is_available)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                        @endif
                                    </p>
                                </div>

                                @if($menu->description)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted small">Deskripsi</label>
                                        <p class="mb-0">{{ $menu->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-kasir-layout>
@endif