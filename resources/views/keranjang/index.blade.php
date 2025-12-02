@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Shopping Cart</h1>
            <p class="text-gray-400">Review your items before checkout</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-gray-300 hover:text-white transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Continue Shopping
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if(!empty($cart))
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $total += $item['harga'] * $item['quantity']; @endphp
                    <div class="bg-white/5 backdrop-blur-xl rounded-xl border border-white/10 shadow-lg overflow-hidden hover:border-white/20 transition-all duration-200">
                        <div class="flex flex-col sm:flex-row">
                            <!-- Product Image -->
                            <div class="sm:w-48 h-48 sm:h-auto flex-shrink-0">
                                @if(isset($item['gambar']) && $item['gambar'])
                                    <img src="{{ asset('storage/' . $item['gambar']) }}" 
                                         alt="{{ $item['nama'] }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-white/5 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 p-6 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-white mb-2">{{ $item['nama'] }}</h3>
                                    <p class="text-gray-400 text-sm mb-4">Rp {{ number_format($item['harga'], 0, ',', '.') }} per item</p>
                                    
                                    <!-- Quantity Control -->
                                    <div class="flex items-center space-x-4 mb-3">
                                        <label class="text-gray-400 text-sm">Quantity:</label>
                                        <input type="number" 
                                               class="quantity-input w-20 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-center focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                               data-id="{{ $id }}" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1">
                                    </div>

                                    <!-- Item Total -->
                                    <p class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                                        Total: Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Remove Button -->
                                <div class="mt-4">
                                    <button class="remove-item-btn inline-flex items-center px-4 py-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/50 text-red-300 rounded-lg transition-all duration-200" data-id="{{ $id }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white/5 backdrop-blur-xl rounded-xl border border-white/10 shadow-lg p-6 sticky top-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Tax (0%)</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="border-t border-white/10 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-white">Total</span>
                                <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('keranjang.checkout') }}" 
                       id="btn-checkout"
                       class="block w-full py-4 px-6 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl text-center transition-all duration-200 shadow-lg shadow-green-500/30 mb-3">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Proceed to Checkout
                    </a>

                    <!-- Clear Cart Button -->
                    <button class="clear-cart-btn w-full py-3 px-6 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
            <div class="mb-8">
                <svg class="w-32 h-32 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-400 mb-2">Your cart is empty</h3>
                <p class="text-gray-500">Add some amazing games to get started!</p>
            </div>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-purple-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Browse Games
            </a>
        </div>
    @endif
</div>

<!-- SweetAlert & Script AJAX -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const totalBelanja = @json($total ?? 0);
    document.addEventListener('DOMContentLoaded', function() {
        // Update jumlah produk dalam keranjang
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                let id = this.getAttribute('data-id');
                let quantity = this.value;

                fetch("{{ route('keranjang.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id: id, quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Failed to update quantity.',
                            background: '#1e293b',
                            color: '#f1f5f9'
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Konfirmasi sebelum Checkout
        document.getElementById('btn-checkout')?.addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Continue to Checkout?",
                html: "Total amount: <strong>Rp " + totalBelanja.toLocaleString('id-ID') + "</strong><br>Please verify all items are correct.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#10b981",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Yes, Checkout",
                cancelButtonText: "Cancel",
                background: '#1e293b',
                color: '#f1f5f9',
                customClass: {
                    popup: 'border border-white/10'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.href;
                }
            });
        });

        // Hapus item dari keranjang dengan SweetAlert
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');

                Swal.fire({
                    title: "Remove this item?",
                    text: "This product will be removed from your cart.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc2626",
                    cancelButtonColor: "#6b7280",
                    confirmButtonText: "Yes, remove it!",
                    cancelButtonText: "Cancel",
                    background: '#1e293b',
                    color: '#f1f5f9',
                    customClass: {
                        popup: 'border border-white/10'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('keranjang.remove') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ id: id })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: 'Product has been removed.',
                                    background: '#1e293b',
                                    color: '#f1f5f9',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Failed to remove product.',
                                    background: '#1e293b',
                                    color: '#f1f5f9'
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });
        });

        // Kosongkan seluruh keranjang dengan SweetAlert
        document.querySelector('.clear-cart-btn')?.addEventListener('click', function() {
            Swal.fire({
                title: "Clear entire cart?",
                text: "All products will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Yes, clear it!",
                cancelButtonText: "Cancel",
                background: '#1e293b',
                color: '#f1f5f9',
                customClass: {
                    popup: 'border border-white/10'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('keranjang.clear') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cleared!',
                                text: 'Cart has been cleared.',
                                background: '#1e293b',
                                color: '#f1f5f9',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: 'Failed to clear cart.',
                                background: '#1e293b',
                                color: '#f1f5f9'
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    });
</script>
@endsection
