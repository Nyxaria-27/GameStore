<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt - E-Itchio</title>
    
    @vite(['resources/css/app.css'])

    <style>
        @media print {
            body {
                background: white;
            }
            .no-print {
                display: none;
            }
            .print-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen py-8 px-4">
    @php 
        use Illuminate\Support\Facades\Route; 
        use Illuminate\Support\Facades\Auth; 
        use App\Models\Produk;
    @endphp

    <div class="max-w-4xl mx-auto">
        <!-- Print Button (Hide on print) -->
        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-gray-300 hover:text-white transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
            <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-purple-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Receipt
            </button>
        </div>

        <!-- Receipt Container -->
        <div class="print-container bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-12 text-white text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-xl rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold">E-Itchio</h1>
                </div>
                <p class="text-blue-100 text-lg">Transaction Receipt</p>
                <p class="text-blue-200 text-sm mt-2">Thank you for your purchase!</p>
            </div>

            <!-- Receipt Info -->
            <div class="px-8 py-8">
                <!-- Transaction Details Grid -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Transaction ID</div>
                        <code class="text-lg font-bold text-gray-900">#{{ $transactions->id }}</code>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Date</div>
                        <div class="text-lg font-semibold text-gray-900">{{ date('d M Y, H:i', strtotime($transactions->created_at ?? now())) }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</div>
                        @php
                            $status = strtolower($transactions->status);
                            $statusConfig = [
                                'success' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '🔄'],
                                'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌'],
                                'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌']
                            ];
                            $config = $statusConfig[$status] ?? $statusConfig['pending'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 {{ $config['bg'] }} {{ $config['text'] }} rounded-lg text-sm font-semibold">
                            <span class="mr-2">{{ $config['icon'] }}</span>
                            {{ ucfirst($transactions->status) }}
                        </span>
                    </div>
                </div>

                <!-- Items Purchased -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Items Purchased
                    </h2>
                    <div class="overflow-hidden border border-gray-200 rounded-xl">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach(json_decode($transactions->items, true) as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $item['nama'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-700">{{ $item['quantity'] }}</td>
                                    <td class="px-6 py-4 text-right text-gray-700">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex justify-end mb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl px-8 py-6 border-2 border-blue-200">
                        <div class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2 text-right">Total Amount</div>
                        <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 text-right">
                            Rp {{ number_format($transactions->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Itch.io Links (if available) -->
                @php
                    $items = json_decode($transactions->items, true);
                    $itchLinks = collect();
                    foreach ($items as $item) {
                        $product = Produk::where('nama', $item['nama'])->first();
                        if ($product && $product->itch_io_link) {
                            $itchLinks->push(['name' => $product->nama, 'link' => $product->itch_io_link]);
                        }
                    }
                    $itchLinks = $itchLinks->unique('link');
                @endphp

                @if($itchLinks->count() > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Game Links
                    </h3>
                    <div class="space-y-2">
                        @foreach($itchLinks as $link)
                        <div class="flex items-center justify-between bg-white rounded-lg p-3">
                            <span class="text-sm text-gray-700">{{ $link['name'] }}</span>
                            <a href="{{ $link['link'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Open Game →
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Footer -->
                <div class="border-t border-gray-200 pt-6 text-center">
                    <p class="text-gray-600 text-sm mb-2">Thank you for shopping with E-Itchio!</p>
                    <p class="text-gray-500 text-xs">For support, please contact us at support@e-itchio.com</p>
                    <div class="mt-4 flex items-center justify-center space-x-2 text-gray-400 text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Secure Transaction</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button (Hide on print) -->
        <div class="mt-6 text-center no-print">
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-xl border border-white/20 text-white font-medium rounded-xl transition-all duration-200">
                View All Transactions
            </a>
        </div>
    </div>
</body>
</html>
