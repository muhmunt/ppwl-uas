@if(auth()->user()->role === 'admin')
    <x-admin-layout>
        <x-slot name="header">
            <h2 class="text-white fw-bold mb-0">
                <i class="bi bi-plus-circle me-2"></i>{{ __('Buat Pesanan Baru') }}
            </h2>
        </x-slot>

        <div class="row g-4">
            <!-- Menu Selection -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-menu-button-wide me-2"></i>Pilih Menu
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($categories as $category)
                            @if($category->menus->count() > 0)
                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3 text-uppercase text-primary">{{ $category->name }}</h6>
                                    <div class="row g-3">
                                        @foreach($category->menus as $menu)
                                            @if($menu->is_available)
                                                <div class="col-6 col-md-4">
                                                    <div class="card border h-100">
                                                        @if($menu->image)
                                                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                        @else
                                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                                <i class="bi bi-image text-muted fs-1"></i>
                                                            </div>
                                                        @endif
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title fw-bold mb-1">{{ $menu->name }}</h6>
                                                            <p class="card-text text-success fw-bold mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                                            <button type="button" onclick="addToCart({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})" 
                                                                class="btn btn-primary btn-sm w-100">
                                                                <i class="bi bi-plus-circle me-1"></i>Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-cart me-2"></i>Keranjang
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Pelanggan</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Meja</label>
                                <input type="text" name="table_number" value="{{ old('table_number') }}" class="form-control">
                            </div>

                            <div id="cart-items" class="mb-3 border rounded p-2" style="min-height: 100px;">
                                <p class="text-muted small mb-0 text-center">Keranjang kosong</p>
                            </div>

                            <div class="mb-3 border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total:</span>
                                    <span id="total-price" class="fw-bold text-success fs-5">Rp 0</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan</label>
                                <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Buat Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let cart = [];
            const menuPrices = {!! json_encode($categories->flatMap->menus->pluck('price', 'id')) !!};

            function addToCart(menuId, menuName, price) {
                const existing = cart.find(item => item.menu_id === menuId);
                if (existing) {
                    existing.quantity++;
                } else {
                    cart.push({ menu_id: menuId, name: menuName, price: price, quantity: 1 });
                }
                updateCart();
            }

            function removeFromCart(index) {
                cart.splice(index, 1);
                updateCart();
            }

            function updateQuantity(index, change) {
                cart[index].quantity += change;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                updateCart();
            }

            function updateCart() {
                const cartItems = document.getElementById('cart-items');
                const totalPrice = document.getElementById('total-price');
                const form = document.getElementById('orderForm');
                
                if (cart.length === 0) {
                    cartItems.innerHTML = '<p class="text-muted small mb-0 text-center">Keranjang kosong</p>';
                    totalPrice.textContent = 'Rp 0';
                    
                    document.querySelectorAll('input[name^="items"]').forEach(input => input.remove());
                    return;
                }

                let html = '';
                let total = 0;
                let itemsInput = '';

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;
                    
                    html += `
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div class="flex-grow-1">
                                <p class="mb-0 small fw-bold">${item.name}</p>
                                <p class="mb-0 text-muted small">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</p>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" onclick="updateQuantity(${index}, -1)" class="btn btn-sm btn-outline-secondary">-</button>
                                <span class="small px-2">${item.quantity}</span>
                                <button type="button" onclick="updateQuantity(${index}, 1)" class="btn btn-sm btn-outline-secondary">+</button>
                                <button type="button" onclick="removeFromCart(${index})" class="btn btn-sm btn-outline-danger ms-2">×</button>
                            </div>
                        </div>
                    `;

                    itemsInput += `
                        <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    `;
                });

                cartItems.innerHTML = html;
                totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
                
                document.querySelectorAll('input[name^="items"]').forEach(input => input.remove());
                form.insertAdjacentHTML('beforeend', itemsInput);
            }

            document.getElementById('orderForm').addEventListener('submit', function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Keranjang tidak boleh kosong!');
                    return false;
                }
            });
        </script>
    </x-admin-layout>
@else
    <x-kasir-layout>
        <x-slot name="header">
            <h2 class="text-white fw-bold mb-0">
                <i class="bi bi-plus-circle me-2"></i>{{ __('Buat Pesanan Baru') }}
            </h2>
        </x-slot>

        <div class="row g-4">
            <!-- Menu Selection -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-menu-button-wide me-2"></i>Pilih Menu
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($categories as $category)
                            @if($category->menus->count() > 0)
                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3 text-uppercase text-primary">{{ $category->name }}</h6>
                                    <div class="row g-3">
                                        @foreach($category->menus as $menu)
                                            @if($menu->is_available)
                                                <div class="col-6 col-md-4">
                                                    <div class="card border h-100">
                                                        @if($menu->image)
                                                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                        @else
                                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                                <i class="bi bi-image text-muted fs-1"></i>
                                                            </div>
                                                        @endif
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title fw-bold mb-1">{{ $menu->name }}</h6>
                                                            <p class="card-text text-success fw-bold mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                                            <button type="button" onclick="addToCart({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})" 
                                                                class="btn btn-primary btn-sm w-100">
                                                                <i class="bi bi-plus-circle me-1"></i>Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-cart me-2"></i>Keranjang
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Pelanggan</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Meja</label>
                                <input type="text" name="table_number" value="{{ old('table_number') }}" class="form-control">
                            </div>

                            <div id="cart-items" class="mb-3 border rounded p-2" style="min-height: 100px;">
                                <p class="text-muted small mb-0 text-center">Keranjang kosong</p>
                            </div>

                            <div class="mb-3 border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total:</span>
                                    <span id="total-price" class="fw-bold text-success fs-5">Rp 0</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan</label>
                                <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Buat Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let cart = [];
            const menuPrices = {!! json_encode($categories->flatMap->menus->pluck('price', 'id')) !!};

            function addToCart(menuId, menuName, price) {
                const existing = cart.find(item => item.menu_id === menuId);
                if (existing) {
                    existing.quantity++;
                } else {
                    cart.push({ menu_id: menuId, name: menuName, price: price, quantity: 1 });
                }
                updateCart();
            }

            function removeFromCart(index) {
                cart.splice(index, 1);
                updateCart();
            }

            function updateQuantity(index, change) {
                cart[index].quantity += change;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                updateCart();
            }

            function updateCart() {
                const cartItems = document.getElementById('cart-items');
                const totalPrice = document.getElementById('total-price');
                const form = document.getElementById('orderForm');
                
                if (cart.length === 0) {
                    cartItems.innerHTML = '<p class="text-muted small mb-0 text-center">Keranjang kosong</p>';
                    totalPrice.textContent = 'Rp 0';
                    
                    document.querySelectorAll('input[name^="items"]').forEach(input => input.remove());
                    return;
                }

                let html = '';
                let total = 0;
                let itemsInput = '';

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;
                    
                    html += `
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div class="flex-grow-1">
                                <p class="mb-0 small fw-bold">${item.name}</p>
                                <p class="mb-0 text-muted small">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</p>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" onclick="updateQuantity(${index}, -1)" class="btn btn-sm btn-outline-secondary">-</button>
                                <span class="small px-2">${item.quantity}</span>
                                <button type="button" onclick="updateQuantity(${index}, 1)" class="btn btn-sm btn-outline-secondary">+</button>
                                <button type="button" onclick="removeFromCart(${index})" class="btn btn-sm btn-outline-danger ms-2">×</button>
                            </div>
                        </div>
                    `;

                    itemsInput += `
                        <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    `;
                });

                cartItems.innerHTML = html;
                totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
                
                document.querySelectorAll('input[name^="items"]').forEach(input => input.remove());
                form.insertAdjacentHTML('beforeend', itemsInput);
            }

            document.getElementById('orderForm').addEventListener('submit', function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Keranjang tidak boleh kosong!');
                    return false;
                }
            });
        </script>
    </x-kasir-layout>
@endif