@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Edit Product</h1>
        <p class="text-gray-400">Update product information</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
        <div class="p-8">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Product Code -->
                <div>
                    <label for="kode_produk" class="block text-sm font-medium text-gray-300 mb-2">
                        Product Code <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="kode_produk" id="kode_produk" value="{{ $produk->kode_produk }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>

                <!-- Product Name -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-300 mb-2">
                        Product Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ $produk->nama }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>

                <!-- Price -->
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-300 mb-2">
                        Price <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">Rp</span>
                        <input type="number" name="harga" id="harga" value="{{ $produk->harga }}" required min="0"
                            class="w-full pl-12 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Category <span class="text-red-400">*</span>
                    </label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="" class="bg-slate-800">-- Select Category --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }} class="bg-slate-800">
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Itch.io Link -->
                <div>
                    <label for="itch_io_link" class="block text-sm font-medium text-gray-300 mb-2">
                        Itch.io Link
                    </label>
                    <input type="url" name="itch_io_link" id="itch_io_link" value="{{ $produk->itch_io_link }}"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="https://example.itch.io/game">
                </div>

                <!-- Current Image Preview -->
                @if($produk->gambar)
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Current Image
                    </label>
                    <div class="relative w-48 h-48 rounded-xl overflow-hidden border border-white/10">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Current Product Image" class="w-full h-full object-cover">
                    </div>
                </div>
                @endif

                <!-- Product Image Upload -->
                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-300 mb-2">
                        Update Product Image
                    </label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-500/20 file:text-blue-400 hover:file:bg-blue-500/30 transition-all duration-200">
                    <p class="mt-2 text-sm text-gray-500">Leave blank to keep current image</p>
                </div>

                <!-- Game File Upload -->
                <div>
                    <label for="file_game" class="block text-sm font-medium text-gray-300 mb-2">
                        Update Game File (ZIP)
                    </label>
                    <input type="file" name="file_game" id="file_game" accept=".zip"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-500/20 file:text-purple-400 hover:file:bg-purple-500/30 transition-all duration-200">
                    @if($produk->file_game)
                        <div class="mt-2 flex items-center text-sm text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Current file:
                            @if(str_contains($produk->file_game, 'games/'))
                                <a href="{{ route('produk.play', $produk->id) }}" target="_blank" class="ml-1 text-blue-400 hover:text-blue-300">View/Play Game</a>
                            @else
                                <a href="{{ route('storage.downloadGame', $produk->id) }}" class="ml-1 text-blue-400 hover:text-blue-300">Download File</a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="5"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Describe your product...">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="flex-1 py-3 px-6 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-green-500/50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Product
                    </button>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.home') }}" class="flex-1 py-3 px-6 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white font-medium rounded-xl text-center transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Dashboard
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="flex-1 py-3 px-6 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white font-medium rounded-xl text-center transition-all duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Home
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
