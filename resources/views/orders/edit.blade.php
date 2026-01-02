@if(auth()->user()->role === 'admin')
    <x-admin-layout>
@else
    <x-kasir-layout>
@endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Menu Selection -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Pilih Menu</h3>
                            @foreach($categories as $category)
                                @if($category->menus->count() > 0)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-2">{{ $category->name }}</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            @foreach($category->menus as $menu)
                                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                                    @if($menu->image)
                                                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="w-full h-32 object-cover rounded mb-2">
                                                    @endif
                                                    <h5 class="font-medium">{{ $menu->name }}</h5>
                                                    <p class="text-sm text-gray-600 mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                                    <button onclick="addToCart({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})" 
                                                        class="w-full bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-2 rounded">
                                                        Tambah
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Cart -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-4">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Keranjang</h3>
                            <form method="POST" action="{{ route('orders.update', $order) }}" id="orderForm">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" class="w-full rounded-md border-gray-300">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Meja</label>
                                    <input type="text" name="table_number" value="{{ old('table_number', $order->table_number) }}" class="w-full rounded-md border-gray-300">
                                </div>

                                <div id="cart-items" class="mb-4 space-y-2">
                                    @if($order->orderItems->count() > 0)
                                        @foreach($order->orderItems as $index => $item)
                                            <div class="flex justify-between items-center border-b pb-2" data-item-id="{{ $item->menu_id }}">
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium">{{ $item->menu->name }}</p>
                                                    <p class="text-xs text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" onclick="updateQuantity({{ $index }}, -1)" class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">-</button>
                                                    <span class="text-sm quantity">{{ $item->quantity }}</span>
                                                    <button type="button" onclick="updateQuantity({{ $index }}, 1)" class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">+</button>
                                                    <button type="button" onclick="removeFromCart({{ $index }})" class="text-red-500 hover:text-red-700 ml-2">×</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500">Keranjang kosong</p>
                                    @endif
                                </div>

                                <div class="mb-4 border-t pt-4">
                                    <div class="flex justify-between font-semibold">
                                        <span>Total:</span>
                                        <span id="total-price">Rp 0</span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                    <textarea name="notes" rows="3" class="w-full rounded-md border-gray-300">{{ old('notes', $order->notes) }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Update Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        const menuPrices = {!! json_encode($categories->flatMap->menus->pluck('price', 'id')) !!};

        // Initialize cart with existing order items
        @if($order->orderItems->count() > 0)
            @foreach($order->orderItems as $item)
                cart.push({
                    menu_id: {{ $item->menu_id }},
                    name: '{{ $item->menu->name }}',
                    price: {{ $item->price }},
                    quantity: {{ $item->quantity }}
                });
            @endforeach
        @endif

        updateCart();

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
                cartItems.innerHTML = '<p class="text-sm text-gray-500">Keranjang kosong</p>';
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
                    <div class="flex justify-between items-center border-b pb-2">
                        <div class="flex-1">
                            <p class="text-sm font-medium">${item.name}</p>
                            <p class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="updateQuantity(${index}, -1)" class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">-</button>
                            <span class="text-sm">${item.quantity}</span>
                            <button type="button" onclick="updateQuantity(${index}, 1)" class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">+</button>
                            <button type="button" onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700 ml-2">×</button>
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
@if(auth()->user()->role === 'admin')
    </x-admin-layout>
@else
    </x-kasir-layout>
@endif
