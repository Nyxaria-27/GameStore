<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Play {{ $produk->nama }} - E-Itchio</title>
    
    @vite(['resources/css/app.css'])

    <style>
        html, body {
            margin: 0;
            height: 100%;
            overflow: hidden;
        }

        #game-frame {
            width: 100vw;
            height: 100vh;
            border: none;
            display: block;
        }

        /* Loader animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">

    <!-- Loader -->
    <div id="loader" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <div class="relative">
            <!-- Spinning Circle -->
            <div class="w-20 h-20 border-4 border-purple-500/30 border-t-purple-500 rounded-full animate-spin"></div>
            <!-- Inner Pulse -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-12 h-12 bg-purple-500/20 rounded-full animate-pulse"></div>
            </div>
        </div>
        <div class="mt-8 flex flex-col items-center space-y-3">
            <p class="text-white text-xl font-semibold">Loading Game...</p>
            <p class="text-gray-400 text-sm">{{ $produk->nama }}</p>
            <div class="flex space-x-1 mt-4">
                <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>

    <!-- Control Buttons -->
    <div id="controls" class="fixed top-0 left-0 right-0 z-40 bg-black/40 backdrop-blur-md border-b border-white/10 px-4 py-3 flex items-center justify-between transition-transform duration-300" style="transform: translateY(0)">
        <!-- Left: Back Button -->
        <a href="{{ route('produk.show', $produk->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 backdrop-blur-xl border border-white/20 text-white rounded-lg transition-all duration-200 group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="font-medium">Back</span>
        </a>

        <!-- Center: Game Title -->
        <div class="hidden md:flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-semibold text-sm">{{ $produk->nama }}</p>
                <p class="text-gray-400 text-xs">Now Playing</p>
            </div>
        </div>

        <!-- Right: Control Buttons -->
        <div class="flex items-center space-x-2">
            <!-- Hide Controls Button -->
            <button id="hide-controls-btn" 
                    class="px-3 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-lg transition-all duration-200"
                    title="Hide Controls (Auto-hide in 3s)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>
            </button>

            <!-- Fullscreen Button -->
            <button id="fullscreen-btn" 
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 flex items-center space-x-2"
                    title="Toggle Fullscreen">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                <span class="hidden sm:inline">Fullscreen</span>
            </button>
        </div>
    </div>

    <!-- Show Controls Button (Hidden by default, shows when controls are hidden) -->
    <button id="show-controls-btn" 
            class="hidden fixed top-4 right-4 z-40 px-3 py-3 bg-black/40 hover:bg-black/60 backdrop-blur-md border border-white/20 text-white rounded-full transition-all duration-200"
            title="Show Controls">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
        </svg>
    </button>

    <!-- Game Frame -->
    <iframe id="game-frame" 
            src="{{ asset('games/' . $produk->file_game . '/index.html') }}" 
            allowfullscreen
            allow="accelerometer; gyroscope; fullscreen"
            class="w-screen h-screen border-0">
    </iframe>

    <script>
        const iframe = document.getElementById('game-frame');
        const loader = document.getElementById('loader');
        const fullscreenBtn = document.getElementById('fullscreen-btn');
        const controls = document.getElementById('controls');
        const hideControlsBtn = document.getElementById('hide-controls-btn');
        const showControlsBtn = document.getElementById('show-controls-btn');
        let hideTimeout;

        // Hide loader when iframe loads
        iframe.onload = function() {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 300);
        };

        // Fallback: Hide loader after 10 seconds
        setTimeout(() => {
            loader.style.display = 'none';
        }, 10000);

        // Fullscreen toggle
        fullscreenBtn.addEventListener('click', () => {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        });

        // Hide controls function
        function hideControls() {
            controls.style.transform = 'translateY(-100%)';
            showControlsBtn.classList.remove('hidden');
        }

        // Show controls function
        function showControls() {
            controls.style.transform = 'translateY(0)';
            showControlsBtn.classList.add('hidden');
            resetHideTimeout();
        }

        // Auto-hide controls after 3 seconds
        function resetHideTimeout() {
            clearTimeout(hideTimeout);
            hideTimeout = setTimeout(hideControls, 3000);
        }

        // Manual hide button
        hideControlsBtn.addEventListener('click', () => {
            clearTimeout(hideTimeout);
            hideControls();
        });

        // Show controls button
        showControlsBtn.addEventListener('click', showControls);

        // Show controls on mouse movement
        document.addEventListener('mousemove', () => {
            if (controls.style.transform === 'translateY(-100%)') {
                showControls();
            } else {
                resetHideTimeout();
            }
        });

        // Initial auto-hide after 3 seconds
        resetHideTimeout();

        // Update fullscreen button icon
        document.addEventListener('fullscreenchange', () => {
            const svg = fullscreenBtn.querySelector('svg');
            if (document.fullscreenElement) {
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            } else {
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>';
            }
        });
    </script>

</body>
</html>
