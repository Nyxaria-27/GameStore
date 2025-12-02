@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Back Button -->
    <div class="mb-6">
        @can('update', $produk)
            <a href="{{ route('admin.home') }}" class="inline-flex items-center text-gray-400 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        @else
            <a href="{{ route('home') }}" class="inline-flex items-center text-gray-400 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        @endcan
    </div>

    <!-- Product Detail Card -->
    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-8 p-8">
            
            <!-- Product Image -->
            <div class="space-y-4">
                @if($produk->gambar)
                    <div class="relative group overflow-hidden rounded-xl">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" 
                             alt="{{ $produk->nama }}" 
                             class="w-full h-auto max-h-[500px] object-cover rounded-xl transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                @else
                    <div class="w-full h-[400px] bg-white/5 border-2 border-dashed border-white/10 rounded-xl flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500">No Image Available</p>
                        </div>
                    </div>
                @endif

                <!-- Category Badge -->
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-lg text-sm font-medium">
                        {{ $produk->kategori->nama ?? 'Uncategorized' }}
                    </span>
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col space-y-6">
                <!-- Title & Price -->
                <div>
                    <h1 class="text-4xl font-bold text-white mb-4">{{ $produk->nama }}</h1>
                    <div class="flex items-baseline space-x-2 mb-6">
                        <span class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                @if($produk->deskripsi)
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold text-gray-300 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Description
                    </h3>
                    <p class="text-gray-400 leading-relaxed">{{ $produk->deskripsi }}</p>
                </div>
                @endif

                <!-- Admin Actions -->
                @can('update', $produk)
                <div class="flex flex-wrap gap-3 pt-4 border-t border-white/10">
                    <a href="{{ route('produk.edit', $produk->id) }}" 
                       class="flex-1 min-w-[150px] py-3 px-6 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl text-center transition-all duration-200 shadow-lg shadow-orange-500/30">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Product
                    </a>
                    <button onclick="confirmDelete({{ $produk->id }})" 
                            class="flex-1 min-w-[150px] py-3 px-6 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg shadow-red-500/30">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                    <form id="delete-form-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @endcan

                <!-- User Actions -->
                @cannot('update', $produk)
                <div class="space-y-3 pt-4 border-t border-white/10">
                    <!-- Buy Button -->
                    <button class="btn-game w-full py-4 px-6 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-purple-500/50 flex items-center justify-center group" data-id="{{ $produk->id }}">
                        <svg class="w-6 h-6 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Add to Cart
                    </button>

                    <!-- Action Buttons Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @if($produk->itch_io_link)
                        <a href="{{ $produk->itch_io_link }}" target="_blank" 
                           class="py-3 px-6 bg-green-500/20 hover:bg-green-500/30 border border-green-500/50 text-green-300 font-medium rounded-xl text-center transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                            </svg>
                            Play on Itch.io
                        </a>
                        @endif

                        @if($produk->file_game)
                        <a href="{{ route('storage.downloadGame', $produk->id) }}" 
                           class="py-3 px-6 bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/50 text-blue-300 font-medium rounded-xl text-center transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Game
                        </a>

                        <a href="{{ route('produk.play', $produk->id) }}" 
                           class="py-3 px-6 bg-purple-500/20 hover:bg-purple-500/30 border border-purple-500/50 text-purple-300 font-medium rounded-xl text-center transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Play Now
                        </a>
                        @endif
                    </div>
                </div>
                @endcannot
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Delete Product?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc2626",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Yes, Delete!",
            cancelButtonText: "Cancel",
            background: '#1e293b',
            color: '#f1f5f9',
            customClass: {
                popup: 'border border-white/10'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.btn-game').forEach(button => {
            button.addEventListener('click', () => {
                const produkId = button.getAttribute('data-id');

                fetch("{{ route('keranjang.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id: produkId, quantity: 1 })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (document.getElementById('cart-count')) {
                            document.getElementById('cart-count').innerText = data.totalItems;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart!',
                            text: 'Redirecting to checkout...',
                            showConfirmButton: false,
                            timer: 2000,
                            background: '#1e293b',
                            color: '#f1f5f9',
                            customClass: {
                                popup: 'border border-white/10'
                            }
                        }).then(() => {
                            window.location.href = "{{ route('keranjang.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: data.message || 'Cannot add product to cart.',
                            background: '#1e293b',
                            color: '#f1f5f9',
                            customClass: {
                                popup: 'border border-white/10'
                            }
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while adding to cart.',
                        background: '#1e293b',
                        color: '#f1f5f9',
                        customClass: {
                            popup: 'border border-white/10'
                            }
                    });
                });
            });
        });
    });
</script>
@endsection
