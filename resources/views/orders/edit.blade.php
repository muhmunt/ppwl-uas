@php
    $isAdmin = auth()->user()->role === 'admin';
    $routePrefix = $isAdmin ? 'admin.' : '';
    
    // Calculate available stock for edit mode (current stock + what's in this order)
    $orderItemsByMenu = $order->orderItems->keyBy('menu_id');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Edit Pesanan</h1>
                <p class="page-subtitle">{{ $order->order_number }}</p>
            </div>
        </div>
    </x-slot>

    {{-- Stock Validation Errors --}}
    @if($errors->any())
        <div class="mb-6">
            <x-ui.alert type="danger">
                <strong>Gagal memperbarui pesanan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Menu Selection --}}
        <div class="lg:col-span-2 space-y-6">
            @foreach($categories as $category)
                @if($category->menus->count() > 0)
                    <x-ui.card>
                        <x-slot name="header">
                            <h3 class="font-semibold text-slate-900">{{ $category->name }}</h3>
                        </x-slot>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($category->menus as $menu)
                                @php
                                    // For edit: available = current stock + qty in this order
                                    $qtyInOrder = $orderItemsByMenu->has($menu->id) ? $orderItemsByMenu->get($menu->id)->quantity : 0;
                                    $effectiveStock = $menu->stock + $qtyInOrder;
                                    $isOutOfStock = $effectiveStock <= 0;
                                    $isLowStock = $effectiveStock > 0 && $effectiveStock <= 5;
                                @endphp
                                <div class="group relative bg-slate-50 rounded-xl overflow-hidden border border-slate-100 hover:border-rose-200 hover:shadow-soft transition-all {{ $isOutOfStock ? 'opacity-60' : '' }}">
                                    @if($menu->image)
                                        <img 
                                            src="{{ Storage::url($menu->image) }}" 
                                            alt="{{ $menu->name }}" 
                                            class="w-full h-32 object-cover {{ $isOutOfStock ? 'grayscale' : '' }}"
                                        >
                                    @else
                                        <div class="w-full h-32 bg-slate-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Stock Badge --}}
                                    <div class="absolute top-2 right-2">
                                        @if($isOutOfStock)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                Habis
                                            </span>
                                        @elseif($isLowStock)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                                Sisa {{ $effectiveStock }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="p-3">
                                        <h4 class="font-medium text-slate-900 text-sm truncate">{{ $menu->name }}</h4>
                                        <div class="flex items-center justify-between mt-1">
                                            <p class="text-emerald-600 font-semibold text-sm">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                            <span class="text-xs text-slate-400">Stok: {{ $effectiveStock }}</span>
                                        </div>
                                        
                                        @if($isOutOfStock)
                                            <button type="button" disabled
                                                class="mt-2 w-full btn btn-secondary btn-sm opacity-50 cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Stok Habis
                                            </button>
                                        @else
                                            <button 
                                                type="button" 
                                                onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }}, {{ $effectiveStock }})"
                                                class="mt-2 w-full btn btn-primary btn-sm"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-ui.card>
                @endif
            @endforeach
        </div>

        {{-- Cart --}}
        <div class="lg:col-span-1">
            <div class="sticky top-6">
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="font-semibold text-slate-900">Keranjang</h3>
                        </div>
                    </x-slot>

                    <form method="POST" action="{{ route($routePrefix . 'orders.update', $order) }}" id="orderForm" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <x-ui.input 
                            name="customer_name" 
                            label="Nama Pelanggan" 
                            :value="old('customer_name', $order->customer_name)"
                            placeholder="Nama pelanggan"
                        />

                        <x-ui.input 
                            name="table_number" 
                            label="Nomor Meja" 
                            :value="old('table_number', $order->table_number)"
                            placeholder="Contoh: 5"
                        />

                        {{-- Cart Items --}}
                        <div>
                            <label class="form-label">Item Pesanan</label>
                            <div id="cart-items" class="min-h-[100px] border border-slate-200 rounded-lg p-3 bg-slate-50">
                                <p class="text-slate-400 text-sm text-center py-4">Keranjang kosong</p>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="flex items-center justify-between py-3 border-t border-slate-200">
                            <span class="font-medium text-slate-700">Total</span>
                            <span id="total-price" class="text-xl font-bold text-emerald-600">Rp 0</span>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="form-label">Catatan</label>
                            <textarea 
                                name="notes" 
                                rows="2" 
                                class="form-input"
                                placeholder="Catatan tambahan..."
                            >{{ old('notes', $order->notes) }}</textarea>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-2">
                            <x-ui.button href="{{ route($routePrefix . 'orders.index') }}" variant="ghost" class="flex-1">
                                Batal
                            </x-ui.button>
                            <x-ui.button type="submit" variant="primary" class="flex-1">
                                Update Pesanan
                            </x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>

    <script>
        // Store menu stock limits (effective stock = current stock + qty in order)
        const menuStock = {
            @foreach($categories as $category)
                @foreach($category->menus as $menu)
                    @php
                        $qtyInOrder = $orderItemsByMenu->has($menu->id) ? $orderItemsByMenu->get($menu->id)->quantity : 0;
                    @endphp
                    {{ $menu->id }}: {{ $menu->stock + $qtyInOrder }},
                @endforeach
            @endforeach
        };

        let cart = [];

        // Initialize cart with existing order items
        @if($order->orderItems->count() > 0)
            @foreach($order->orderItems as $item)
                cart.push({
                    menu_id: {{ $item->menu_id }},
                    name: '{{ addslashes($item->menu->name) }}',
                    price: {{ $item->price }},
                    quantity: {{ $item->quantity }},
                    maxStock: menuStock[{{ $item->menu_id }}] || 0
                });
            @endforeach
        @endif

        // Initialize cart display
        updateCart();

        function addToCart(menuId, menuName, price, maxStock) {
            const existing = cart.find(item => item.menu_id === menuId);
            const currentQty = existing ? existing.quantity : 0;
            
            // Check if adding would exceed stock
            if (currentQty >= maxStock) {
                alert(`Stok "${menuName}" tidak mencukupi. Maksimal: ${maxStock}`);
                return;
            }
            
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({ menu_id: menuId, name: menuName, price: price, quantity: 1, maxStock: maxStock });
            }
            updateCart();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        function updateQuantity(index, change) {
            const item = cart[index];
            const newQty = item.quantity + change;
            
            // Check stock limit when increasing
            if (change > 0 && newQty > item.maxStock) {
                alert(`Stok "${item.name}" tidak mencukupi. Maksimal: ${item.maxStock}`);
                return;
            }
            
            item.quantity = newQty;
            if (item.quantity <= 0) {
                cart.splice(index, 1);
            }
            updateCart();
        }

        function updateCart() {
            const cartItems = document.getElementById('cart-items');
            const totalPrice = document.getElementById('total-price');
            const form = document.getElementById('orderForm');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-slate-400 text-sm text-center py-4">Keranjang kosong</p>';
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
                const isAtMax = item.quantity >= item.maxStock;
                
                html += `
                    <div class="flex items-center justify-between py-2 ${index < cart.length - 1 ? 'border-b border-slate-200' : ''}">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate">${item.name}</p>
                            <p class="text-xs text-slate-500">Rp ${item.price.toLocaleString('id-ID')} × ${item.quantity}</p>
                            ${isAtMax ? '<p class="text-xs text-amber-600">Maks. stok tercapai</p>' : ''}
                        </div>
                        <div class="flex items-center gap-1 ml-2">
                            <button type="button" onclick="updateQuantity(${index}, -1)" class="w-6 h-6 flex items-center justify-center rounded bg-slate-200 text-slate-600 hover:bg-slate-300 text-sm">−</button>
                            <span class="w-6 text-center text-sm">${item.quantity}</span>
                            <button type="button" onclick="updateQuantity(${index}, 1)" class="w-6 h-6 flex items-center justify-center rounded ${isAtMax ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-slate-200 text-slate-600 hover:bg-slate-300'} text-sm" ${isAtMax ? 'disabled' : ''}>+</button>
                            <button type="button" onclick="removeFromCart(${index})" class="w-6 h-6 flex items-center justify-center rounded text-red-500 hover:bg-red-50 ml-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
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
</x-app-layout>